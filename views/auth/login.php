<div id="auth" class="auth-login-shell">
    <div class="auth-galaxy" aria-hidden="true">
        <canvas class="auth-galaxy__canvas" id="auth-galaxy-canvas"></canvas>
        <span class="auth-galaxy__nebula auth-galaxy__nebula--one"></span>
        <span class="auth-galaxy__nebula auth-galaxy__nebula--two"></span>
        <span class="auth-galaxy__nebula auth-galaxy__nebula--three"></span>
        <span class="auth-galaxy__stars"></span>
        <span class="auth-galaxy__orbit auth-galaxy__orbit--one"></span>
        <span class="auth-galaxy__orbit auth-galaxy__orbit--two"></span>
    </div>
    <div class="auth-login-panel auth-login-panel--single">
        <div id="auth-card">
            <div class="auth-brand-chip">PAMER OPERATIONS</div>

            <div class="auth-logo text-center mb-4">
                <img src="/src/img/PAMERVAL-LOGO.png" alt="Pamerval" class="auth-logo__image">
            </div>

            <h2 class="auth-title text-center">Iniciar sesion</h2>
            <p class="auth-subtitle text-center mb-4">
                Ingresa con las credenciales registradas para continuar.
            </p>

            <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

            <form action="/" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="correo@empresa.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu password">
                    </div>
                </div>

                <div class="form-check d-flex align-items-center mb-4">
                    <input class="form-check-input me-2" type="checkbox" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Mantener sesion activa en este equipo
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar al sistema</button>
            </form>
        </div>
    </div>
</div>
<script>
    (() => {
        const canvas = document.getElementById('auth-galaxy-canvas');
        if (!canvas) return;

        const mediaReduce = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (mediaReduce.matches) return;

        const context = canvas.getContext('2d');
        if (!context) return;

        const particles = [];
        const pointer = {
            x: null,
            y: null,
            radius: 120
        };

        let width = 0;
        let height = 0;
        let animationFrame = null;
        let particleCount = 0;

        function resizeCanvas() {
            const ratio = window.devicePixelRatio || 1;
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = Math.floor(width * ratio);
            canvas.height = Math.floor(height * ratio);
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            context.setTransform(ratio, 0, 0, ratio, 0, 0);

            particleCount = Math.max(28, Math.min(72, Math.floor((width * height) / 28000)));
            particles.length = 0;

            for (let index = 0; index < particleCount; index += 1) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 0.45,
                    vy: (Math.random() - 0.5) * 0.45,
                    size: Math.random() * 1.9 + 0.8,
                    alpha: Math.random() * 0.45 + 0.25
                });
            }
        }

        function drawParticle(particle) {
            context.beginPath();
            context.fillStyle = `rgba(255,255,255,${particle.alpha})`;
            context.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            context.fill();
        }

        function drawLinks() {
            for (let i = 0; i < particles.length; i += 1) {
                for (let j = i + 1; j < particles.length; j += 1) {
                    const a = particles[i];
                    const b = particles[j];
                    const dx = a.x - b.x;
                    const dy = a.y - b.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance > 110) continue;

                    context.beginPath();
                    context.strokeStyle = `rgba(125,211,252,${(1 - (distance / 110)) * 0.14})`;
                    context.lineWidth = 0.8;
                    context.moveTo(a.x, a.y);
                    context.lineTo(b.x, b.y);
                    context.stroke();
                }
            }
        }

        function animate() {
            context.clearRect(0, 0, width, height);

            for (const particle of particles) {
                if (pointer.x !== null && pointer.y !== null) {
                    const dx = particle.x - pointer.x;
                    const dy = particle.y - pointer.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < pointer.radius && distance > 0) {
                        const force = (pointer.radius - distance) / pointer.radius;
                        particle.vx += (dx / distance) * force * 0.08;
                        particle.vy += (dy / distance) * force * 0.08;
                    }
                }

                particle.x += particle.vx;
                particle.y += particle.vy;
                particle.vx *= 0.985;
                particle.vy *= 0.985;

                if (particle.x < -10) particle.x = width + 10;
                if (particle.x > width + 10) particle.x = -10;
                if (particle.y < -10) particle.y = height + 10;
                if (particle.y > height + 10) particle.y = -10;

                drawParticle(particle);
            }

            drawLinks();
            animationFrame = window.requestAnimationFrame(animate);
        }

        window.addEventListener('mousemove', (event) => {
            pointer.x = event.clientX;
            pointer.y = event.clientY;
        }, { passive: true });

        window.addEventListener('mouseleave', () => {
            pointer.x = null;
            pointer.y = null;
        });

        window.addEventListener('touchmove', (event) => {
            const touch = event.touches[0];
            if (!touch) return;
            pointer.x = touch.clientX;
            pointer.y = touch.clientY;
        }, { passive: true });

        window.addEventListener('touchend', () => {
            pointer.x = null;
            pointer.y = null;
        }, { passive: true });

        window.addEventListener('resize', resizeCanvas, { passive: true });

        resizeCanvas();
        animate();

        window.addEventListener('beforeunload', () => {
            if (animationFrame) {
                window.cancelAnimationFrame(animationFrame);
            }
        });
    })();
</script>
