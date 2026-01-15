<!-- views/admin/vehiculos/registroVehiculos.php -->
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($titulo ?? 'Registro de Vehículos') ?></title>
<style>
  body { font-family: system-ui, sans-serif; margin:0; }
  .bar { display:flex; gap:12px; align-items:center; padding:10px; background:#f6f6f6; flex-wrap:wrap; }
  .bar > * { margin: 2px 0; }
  input, select, button { font-size: 1rem; padding: 6px 10px; }
  #status { color:#555; font-size:0.95rem; }
  #log { padding:10px; font-size:0.9rem; color:#333; }
  .ok { color: #1a7f37; }
  .warn { color: #b36b00; }
  .err { color: #b00020; }
</style>
</head>
<body>

<div class="bar">
  <div><strong>Hola, <?= htmlspecialchars($nombre ?? '') ?></strong></div>

  <label>
    Vehículo:
    <select id="vehicleSelect">
      <option value="">-- Selecciona --</option>
      <?php if (!empty($vehiculos ?? [])) : ?>
        <?php foreach ($vehiculos as $v): ?>
          <option value="<?= htmlspecialchars($v['code']) ?>">
            <?= htmlspecialchars($v['code'] . (!empty($v['name']) ? " - {$v['name']}" : "")) ?>
          </option>
        <?php endforeach; ?>
      <?php endif; ?>
    </select>
  </label>

  <span>o</span>

  <label>
    Código manual:
    <input id="vehicleCode" placeholder="CAMION-12">
  </label>

  <button id="startBtn">Iniciar</button>
  <button id="stopBtn" disabled>Detener</button>

  <span id="status" class="warn">Usa HTTPS para geolocalización precisa.</span>
</div>

<div id="log"></div>

<script>
/** CONFIG **/
const API_URL = '/api/locations/store'; // ajusta si tu base URL es distinta
const SEND_INTERVAL_MS = 5000;          // mínimo 5s entre envíos
const MIN_MOVE_METERS = 10;             // enviar solo si se movió ≥ 10 m

/** ESTADO **/
let watchId = null;
let vehicleCode = null;
let vehicleName = null; // si lo quieres mandar como snapshot
let lastSentTime = 0;
let lastSentCoords = null;

/** UI helpers **/
const $ = (sel) => document.querySelector(sel);
function setStatus(text, cls='') {
  const el = $('#status');
  el.textContent = text;
  el.className = cls;
}
function log(msg) {
  const el = $('#log');
  const time = new Date().toLocaleTimeString();
  el.innerHTML = `[${time}] ${msg}<br>` + el.innerHTML;
}

/** Geodesia simple (distancia en metros) **/
function haversineMeters(a, b) {
  if (!a || !b) return Infinity;
  const R = 6371000;
  const toRad = d => d * Math.PI / 180;
  const dLat = toRad(b.lat - a.lat);
  const dLng = toRad(b.lng - a.lng);
  const lat1 = toRad(a.lat);
  const lat2 = toRad(b.lat);
  const sinDLat = Math.sin(dLat/2), sinDLng = Math.sin(dLng/2);
  const h = sinDLat*sinDLat + Math.cos(lat1)*Math.cos(lat2)*sinDLng*sinDLng;
  return 2 * R * Math.asin(Math.sqrt(h));
}

/** Enviar punto al backend **/
async function sendPoint(pos) {
  if (!vehicleCode) return;

  const measuredAt = new Date().toISOString().slice(0,19).replace('T',' ');
  const body = {
    vehicle_code: vehicleCode,
    vehicle_name: vehicleName || null,
    lat: pos.coords.latitude,
    lng: pos.coords.longitude,
    accuracy: pos.coords.accuracy,
    heading: pos.coords.heading,
    speed: pos.coords.speed,
    measured_at: measuredAt
  };

  try {
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type':'application/json' },
      body: JSON.stringify(body)
    });

    // Diagnóstico robusto para evitar "Unexpected token '<'"
    const text = await res.text();
    const ct = res.headers.get('content-type') || '';

    if (!res.ok) {
      log(`❌ HTTP ${res.status}: ${text.slice(0,200)}`);
      setStatus('Error del servidor', 'err');
      return;
    }
    if (!ct.includes('application/json')) {
      log(`❌ Respuesta no JSON (CT=${ct}): ${text.slice(0,200)}`);
      setStatus('Respuesta no JSON', 'err');
      return;
    }

    let j;
    try { j = JSON.parse(text); }
    catch (e) {
      log('❌ JSON inválido: ' + e.message + ' :: ' + text.slice(0,200));
      setStatus('JSON inválido', 'err');
      return;
    }

    if (!j.ok) {
      setStatus('Error enviando ubicación', 'err');
      log('❌ Backend: ' + (j.error || 'Error desconocido'));
    } else {
      setStatus('Rastreando…', 'ok');
      log('✅ Enviado');
    }
  } catch (e) {
    setStatus('Sin conexión al servidor', 'err');
    log('❌ Fetch: ' + e.message);
  }
}

/** Iniciar seguimiento **/
function startTracking() {
  if (watchId) return;

  const sel = ($('#vehicleSelect').value || '').trim();
  const manual = ($('#vehicleCode').value || '').trim();
  vehicleCode = manual || sel;
  if (!vehicleCode) {
    alert('Selecciona o ingresa un código de vehículo.');
    return;
  }
  vehicleName = null;

  if (!('geolocation' in navigator)) {
    setStatus('Geolocalización no soportada en este navegador', 'err');
    return;
  }

  lastSentTime = 0;
  lastSentCoords = null;

  watchId = navigator.geolocation.watchPosition(
    (pos) => {
      const now = Date.now();
      const coords = { lat: pos.coords.latitude, lng: pos.coords.longitude };
      const dtOk = (now - lastSentTime) >= SEND_INTERVAL_MS;
      const moved = haversineMeters(lastSentCoords, coords) >= MIN_MOVE_METERS;

      if (dtOk || moved || lastSentCoords === null) {
        lastSentTime = now;
        lastSentCoords = coords;
        sendPoint(pos);
      }
    },
    (err) => {
      setStatus('Error: ' + err.message, 'err');
      log('❌ Geolocation: ' + err.message);
    },
    { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 }
  );

  $('#startBtn').disabled = true;
  $('#stopBtn').disabled  = false;
  setStatus('Solicitando ubicación… acepta el permiso', 'warn');

  window.addEventListener('beforeunload', stopTracking, { once:true });
  window.addEventListener('pagehide', stopTracking, { once:true });
}

/** Detener seguimiento **/
function stopTracking() {
  if (watchId) {
    navigator.geolocation.clearWatch(watchId);
    watchId = null;
  }
  $('#startBtn').disabled = false;
  $('#stopBtn').disabled  = true;
  setStatus('Detenido', 'warn');
}

$('#startBtn').addEventListener('click', startTracking);
$('#stopBtn').addEventListener('click', stopTracking);

setStatus('Listo. Selecciona un vehículo y pulsa “Iniciar”.', 'warn');
</script>

</body>
</html>
