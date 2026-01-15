// document.addEventListener("DOMContentLoaded", function () {
//   ApiConsumo();
//   ApiConsumo2();
// });

// async function ApiConsumo() {
//   try {
//     const url = `${location.origin}/admin/api/apiGraficasConsumoGeneral`;
//     const resultado = await fetch(url);
//     const ApiConsumo = await resultado.json();
//     // console.log(ApiConsumo);

//     return ApiConsumo;
//   } catch (e) {
//     console.log(e);
//   }
// }

// document.addEventListener("DOMContentLoaded", () => {
//   const card = document.getElementById("abrirModalTarjetas");

//   if (card) {
//     card.addEventListener("click", async () => {
//       // Llamada a tu API y renderizado
//       await ApiConsumo2();

//       // Mostrar el modal (requiere Bootstrap 5)
//       const modal = new bootstrap.Modal(
//         document.getElementById("modalTarjetas")
//       );
//       modal.show();
//     });
//   }
// });

// async function ApiConsumo2() {
//   try {
//     const url = `${location.origin}/admin/api/apiGraficasConsumoGeneral`;
//     const resultado = await fetch(url);
//     const data = await resultado.json();
//     renderTarjetas(data);
//   } catch (e) {
//     console.log(e);
//   }
// }

// const iconosMaquinas = {
//   TROQUEL: { icono: "fa-solid fa-scissors", color: "danger" },
//   "PRE-PRINTER": { icono: "fa-solid fa-print", color: "info" },
//   "GUILLOTINA LAMINA": { icono: "fa-solid fa-cut", color: "primary" },
//   "GUILLOTINA PAPEL": { icono: "fa-solid fa-", color: "primary" },
//   CORRUGADOR: { icono: "fa-solid fa-layer-group", color: "warning" },
//   FLEXOGRAFICA: { icono: "fa-solid fa-pen-nib", color: "info" },
//   MICRO: { icono: "fa-solid fa-microchip", color: "secondary" },
//   EMPAQUE: { icono: "fa-solid fa-box", color: "success" },
//   DOBLADO: { icono: "fa-solid fa-object-ungroup", color: "primary" },
//   BODEGA: { icono: "fa-solid fa-warehouse", color: "dark" },
//   CONVERTIDOR: { icono: "fa-solid fa-recycle", color: "secondary" },
//   "DESHOJE-CONVERTIDOR": {
//     icono: "fa-solid fa-file-arrow-down",
//     color: "warning",
//   },
//   "DESHOJE-PRE-PRINTER": { icono: "fa-solid fa-file-pen", color: "info" },
// };

// function renderTarjetas(data) {
//   const contenedor = document.getElementById("contenedor-tarjetas");
//   contenedor.innerHTML = "";

//   const maquinasAgrupadas = {};

//   // Agrupar por tipo_maquina y sumar total_general
//   data.forEach((item) => {
//     const nombre = item.tipo_maquina.trim();
//     const total = parseFloat(item.total_general);

//     if (maquinasAgrupadas[nombre]) {
//       maquinasAgrupadas[nombre] += total;
//     } else {
//       maquinasAgrupadas[nombre] = total;
//     }
//   });

//   // Generar tarjetas con íconos y colores personalizados
//   for (const [maquina, total] of Object.entries(maquinasAgrupadas)) {
//     const config = iconosMaquinas[maquina] || {
//       icono: "iconly-boldInfoCircle",
//       color: "secondary",
//     };

//     const tarjetaHTML = `
//                 <div class="col-6 col-lg-3 col-md-6">
//                     <div class="card">
//                         <div class="card-body px-3 py-4-5">
//                             <div class="row">
//                                 <div class="col-md-4">
//                                     <div class="stats-icon ${config.color}">
//                                         <i class="${config.icono}"></i>
//                                     </div>
//                                 </div>
//                                 <div class="col-md-8">
//                                     <h6 class="text-muted font-semibold">${maquina}</h6>
//                                     <h6 class="font-extrabold mb-0">${total.toFixed(
//                                       2
//                                     )}</h6>
//                                 </div>
//                             </div>
//                         </div>
//                     </div>
//                 </div>`;
//     contenedor.innerHTML += tarjetaHTML;
//   }
// }

// async function cargarGraficoTopMaquinas(
//   fechaInicio,
//   fechaFin,
//   topSeleccionado,
//   maquinaSeleccionada
// ) {
//   const datosAPI = await ApiConsumo();

//   const inicio = new Date(fechaInicio + "T00:00:00");
//   const fin = new Date(fechaFin + "T23:59:59");

//   // Filtrar por rango de fechas
//   let datosFiltrados = datosAPI.filter((item) => {
//     const fecha = new Date(item.created_at + "T00:00:00");
//     return fecha >= inicio && fecha <= fin;
//   });

//   // Filtrar por tipo de máquina
//   if (maquinaSeleccionada !== "todos") {
//     datosFiltrados = datosFiltrados.filter(
//       (item) =>
//         // quitar espacios y comparar en minúsculas
//         item.tipo_maquina.trim().toLowerCase() ===
//         maquinaSeleccionada.trim().toLowerCase()
//     );
//   }

//   if (datosFiltrados.length === 0) {
//     alert("No se encontraron datos para los filtros seleccionados.");
//     return;
//   }

//   const fechasUnicas = [
//     ...new Set(
//       datosFiltrados.map((item) => {
//         const fecha = new Date(item.created_at + "T00:00:00");
//         return fecha.toLocaleDateString("default", {
//           day: "2-digit",
//           month: "short",
//         });
//       })
//     ),
//   ];

//   const agrupadoMaquinas = {};
//   datosFiltrados.forEach((item) => {
//     const fecha = new Date(item.created_at + "T00:00:00").toLocaleDateString(
//       "default",
//       { day: "2-digit", month: "short" }
//     );
//     const tipo = item.tipo_maquina;
//     const total = parseFloat(item.total_general);

//     if (!agrupadoMaquinas[tipo]) {
//       agrupadoMaquinas[tipo] = {};
//     }
//     agrupadoMaquinas[tipo][fecha] =
//       (agrupadoMaquinas[tipo][fecha] || 0) + (isNaN(total) ? 0 : total);
//   });

//   let resumenMaquinas = Object.entries(agrupadoMaquinas).map(
//     ([nombre, datos]) => {
//       const total = Object.values(datos).reduce((sum, val) => sum + val, 0);
//       return { nombre, total, datos };
//     }
//   );

//   if (topSeleccionado !== "todos") {
//     resumenMaquinas = resumenMaquinas
//       .sort((a, b) => b.total - a.total)
//       .slice(0, parseInt(topSeleccionado));
//   }

//   const seriesMaquinas = resumenMaquinas.map(({ nombre, datos }) => {
//     const dataPorFecha = fechasUnicas.map((fecha) => datos[fecha] || 0);
//     return {
//       name: nombre,
//       data: dataPorFecha,
//     };
//   });

//   const colores = ["#435ebe", "#55c6e8", "#f59e0b", "#10b981", "#ef4444"];

//   const opcionesGrafico = {
//     annotations: { position: "back" },
//     dataLabels: { enabled: false },
//     chart: {
//       type: "bar",
//       height: 300,
//       stacked: false,
//     },
//     fill: { opacity: 1 },
//     plotOptions: {
//       bar: {
//         borderRadius: 4,
//         horizontal: false,
//       },
//     },
//     series: seriesMaquinas,
//     colors: colores,
//     xaxis: {
//       categories: fechasUnicas,
//       title: { text: "Día" },
//     },
//     yaxis: {
//       labels: {
//         formatter: function (value) {
//           return value.toFixed(2);
//         },
//       },
//     },
//   };

//   const contenedor = document.querySelector("#grafico-top-maquinas");
//   contenedor.innerHTML = ""; // Limpiar gráfico anterior

//   const grafico = new ApexCharts(contenedor, opcionesGrafico);
//   grafico.render();
// }

// // Escuchar el formulario
// document.addEventListener("DOMContentLoaded", function () {
//   const form = document.getElementById("formFiltroTopMaquinas");

//   form.addEventListener("submit", function (e) {
//     e.preventDefault();

//     const fechaInicio = document.getElementById("filtroFechaInicio").value;
//     const fechaFin = document.getElementById("filtroFechaFin").value;
//     const top = document.getElementById("filtroTopMaquinas").value;
//     const maquina = document.getElementById("filtroTipoMaquina").value;

//     if (!fechaInicio || !fechaFin) {
//       alert("Selecciona una fecha de inicio y fin válida.");
//       return;
//     }

//     cargarGraficoTopMaquinas(fechaInicio, fechaFin, top, maquina);
//   });
// });






// document.addEventListener("DOMContentLoaded", () => {
//   const contenedorGrafico = document.querySelector("#graficoUnico");

//   function filtrarPorFechas(datos, inicio, fin) {
//     const desde = new Date(inicio);
//     const hasta = new Date(fin);
//     return datos.filter((item) => {
//       const fecha = new Date(item.created_at);
//       return fecha >= desde && fecha <= hasta;
//     });
//   }

//   function agruparDatos(datos) {
//     const agrupado = {};
//     datos.forEach((item) => {
//       const maquina = item.tipo_maquina.trim();
//       const fecha = new Date(item.created_at).toISOString().split("T")[0];
//       const total = parseFloat(item.total_general);

//       if (!agrupado[maquina]) agrupado[maquina] = {};
//       agrupado[maquina][fecha] = (agrupado[maquina][fecha] || 0) + total;
//     });
//     return agrupado;
//   }

//   function generarColor(index) {
//     const colores = [
//       "#008FFB",
//       "#00E396",
//       "#FF4560",
//       "#775DD0",
//       "#FEB019",
//       "#546E7A",
//       "#26a69a",
//       "#d4526e",
//       "#8d6e63",
//       "#f1c40f",
//       "#bdc3c7"
        
//     ];
//     return colores[index % colores.length];
//   }

//   async function cargarDatos(fechaInicio = null, fechaFin = null) {
//     try {
//       const res = await fetch(
//         "https://pruebas.megawebsistem.com/admin/api/apiGraficasConsumoGeneral"
//       );
//       const datos = await res.json();

//       let datosFiltrados = datos;
//       if (fechaInicio && fechaFin) {
//         datosFiltrados = filtrarPorFechas(datos, fechaInicio, fechaFin);
//       }

//       const agrupado = agruparDatos(datosFiltrados);
//       const series = [];

//       let index = 0;
//       for (const [maquina, fechas] of Object.entries(agrupado)) {
//         const data = Object.entries(fechas)
//           .sort(([a], [b]) => new Date(a) - new Date(b))
//           .map(([fecha, valor]) => ({
//             x: fecha,
//             y: parseFloat(valor.toFixed(2)),
//           }));

//         series.push({
//           name: maquina,
//           data: data,
//         });

//         index++;
//       }

//       contenedorGrafico.innerHTML = ""; // Limpiar gráfico anterior

//       const chart = new ApexCharts(contenedorGrafico, {
//         chart: {
//           type: "line",
//           height: 400,
//           zoom: {
//             enabled: true,
//           },
//           locales: [
//             {
//               name: "es",
//               options: {
//                 months: [
//                   "Enero",
//                   "Febrero",
//                   "Marzo",
//                   "Abril",
//                   "Mayo",
//                   "Junio",
//                   "Julio",
//                   "Agosto",
//                   "Septiembre",
//                   "Octubre",
//                   "Noviembre",
//                   "Diciembre",
//                 ],
//                 shortMonths: [
//                   "Ene",
//                   "Feb",
//                   "Mar",
//                   "Abr",
//                   "May",
//                   "Jun",
//                   "Jul",
//                   "Ago",
//                   "Sep",
//                   "Oct",
//                   "Nov",
//                   "Dic",
//                 ],
//                 days: [
//                   "Domingo",
//                   "Lunes",
//                   "Martes",
//                   "Miércoles",
//                   "Jueves",
//                   "Viernes",
//                   "Sábado",
//                 ],
//                 shortDays: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
//                 toolbar: {
//                   exportToSVG: "Descargar SVG",
//                   exportToPNG: "Descargar PNG",
//                   exportToCSV: "Descargar CSV",
//                   menu: "Menú",
//                   selection: "Selección",
//                   selectionZoom: "Zoom de selección",
//                   zoomIn: "Acercar",
//                   zoomOut: "Alejar",
//                   pan: "Mover",
//                   reset: "Restablecer Zoom",
//                 },
//               },
//             },
//           ],
//           defaultLocale: "es",
//         },
//         series: series,
//         xaxis: {
//           type: "datetime",
//           title: {
//             text: "Fecha",
//           },
//         },
//         yaxis: {
//           title: {
//             text: "Consumo General",
//           },
//           labels: {
//             formatter: (val) => val.toFixed(2),
//           },
//         },
//         stroke: {
//           curve: "smooth",
//           width: 2,
//         },
//         colors: series.map((_, i) => generarColor(i)),
//         tooltip: {
//           x: {
//             format: "dd MMM yyyy",
//           },
//           y: {
//             formatter: (val) => val.toFixed(2),
//           },
//         },
//         legend: {
//           position: "top",
//         },
//         title: {
//           text: "Consumo Diario por Máquina",
//           align: "center",
//         },
//       });

//       chart.render();
//     } catch (error) {
//       console.error("Error al cargar los datos:", error);
//     }
//   }

//   // Manejar envío de formulario
//   document
//     .getElementById("formFiltroMaquinas")
//     .addEventListener("submit", (e) => {
//       e.preventDefault();
//       const fechaInicio = document.getElementById("inputFechaInicio").value;
//       const fechaFin = document.getElementById("inputFechaFin").value;
//       cargarDatos(fechaInicio, fechaFin);
//     });

//   // Cargar gráfico al inicio
//   cargarDatos();
// });





// document.addEventListener("DOMContentLoaded", () => {
//   cargarGraficaMensual();
// });

// async function cargarGraficaMensual() {
//   try {
//     const url = `${location.origin}/admin/api/apiGraficasConsumoGeneral`;
//     const resultado = await fetch(url);
//     const data = await resultado.json();

//     const meses = [
//       "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
//       "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
//     ];

//     // Agrupar consumo por máquina y mes
//     const consumoPorMaquina = {};

//     data.forEach(item => {
//       const fecha = new Date(item.created_at);
//       const mes = fecha.getMonth(); // 0 = Enero, 11 = Diciembre
//       const maquina = item.maquina || "Sin Nombre";
//       const total = parseFloat(item.total_general) || 0;

//       if (!consumoPorMaquina[maquina]) {
//         consumoPorMaquina[maquina] = Array(12).fill(0);
//       }

//       consumoPorMaquina[maquina][mes] += total;
//     });

//     // Convertir a series de ApexCharts
//     const series = Object.entries(consumoPorMaquina).map(([maquina, datos]) => ({
//       name: maquina,
//       data: datos
//     }));

//     const opcionesGrafico = {
//       chart: {
//         type: 'bar',
//         height: 400,
//         stacked: false,
//         toolbar: {
//           show: true
//         }
//       },
//       series: series,
//       plotOptions: {
//         bar: {
//           horizontal: false,
//           columnWidth: '60%',
//           endingShape: 'rounded'
//         }
//       },
//       dataLabels: {
//         enabled: false
//       },
//       xaxis: {
//         categories: meses,
//         title: {
//           text: "Mes"
//         }
//       },
//       yaxis: {
//         title: {
//           text: "Consumo Total"
//         }
//       },
//       fill: {
//         opacity: 1
//       },
//       tooltip: {
//         y: {
//           formatter: val => `${val.toFixed(2)}`
//         }
//       },
//       title: {
//         text: "Consumo Mensual por Máquina",
//         align: "center"
//       },
//       legend: {
//         position: 'bottom'
//       }
//     };

//     const contenedor = document.querySelector("#grafico-mensual");
//     contenedor.innerHTML = "";

//     const grafico = new ApexCharts(contenedor, opcionesGrafico);
//     grafico.render();
//   } catch (e) {
//     console.error("Error al cargar la gráfica:", e);
//   }
// }




// document.addEventListener('DOMContentLoaded', function () {

//     async function ApiConsumoGeneralxmesymaquina() {
//         try {
//             const url = `${location.origin}/admin/api/apiGraficasConsumoGeneral`;
//             const resultado = await fetch(url);
//             const datos = await resultado.json();
//             return datos;
//         } catch (e) {
//             console.error(e);
//             return [];
//         }
//     }

//     function formatearMes(fecha) {
//         const opciones = { year: 'numeric', month: 'short' };
//         return new Date(fecha).toLocaleDateString('es-ES', opciones);
//     }

//     function agruparDatosPorMaquinaYMes(datos) {
//         const maquinas = {};
//         const mesesSet = new Set();

//         datos.forEach(item => {
//             const mes = formatearMes(item.created_at);
//             mesesSet.add(mes);

//             if (!maquinas[item.tipo_maquina]) {
//                 maquinas[item.tipo_maquina] = {};
//             }

//             if (!maquinas[item.tipo_maquina][mes]) {
//                 maquinas[item.tipo_maquina][mes] = 0;
//             }

//             maquinas[item.tipo_maquina][mes] += parseFloat(item.total_general);
//         });

//         const meses = Array.from(mesesSet).sort((a, b) => new Date(a) - new Date(b));

//         const series = Object.keys(maquinas).map(maquina => {
//             const data = meses.map(mes => maquinas[maquina][mes] || 0);
//             return { name: maquina, data };
//         });

//         return { series, categorias: meses };
//     }

//     ApiConsumoGeneralxmesymaquina().then(datosApi => {
//         const { series, categorias } = agruparDatosPorMaquinaYMes(datosApi);

//         const options = {
//             series,
//             chart: {
//                 type: 'bar',
//                 height: 350,
//                 stacked: true,
//                 stackType: '100%'
//             },
//             xaxis: {
//                 categories: categorias
//             },
//             fill: {
//                 opacity: 1
//             },
//             legend: {
//                 position: 'right',
//                 offsetX: 0,
//                 offsetY: 50
//             },
//             responsive: [{
//                 breakpoint: 480,
//                 options: {
//                     legend: {
//                         position: 'bottom',
//                         offsetX: -10,
//                         offsetY: 0
//                     }
//                 }
//             }]
//         };

//         const chart = new ApexCharts(document.querySelector("#chart"), options);
//         chart.render();
//     });

// });