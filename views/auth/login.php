<div id="auth" class="auth-login-shell">
    <div class="auth-login-panel auth-login-panel--single">
        <div id="auth-card">
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
