<div id="auth" class="d-flex justify-content-center align-items-center">
    <div id="auth-card">
      <div class="auth-logo text-center mb-3">
        <span>EN DESARROLLO 😶‍🌫️</span>
      </div>

      <h1 class="auth-title text-center">Login.</h1>
      <p class="auth-subtitle text-center mb-4">
        Inicie sesión con los datos que ingresó durante el registro.
      </p>

      <form action="/" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email:</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" id="email" name="email" class="form-control" placeholder="email">
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" id="password" name="password" class="form-control" placeholder="password">
          </div>
        </div>

        <div class="form-check d-flex align-items-center mb-3">
          <input class="form-check-input me-2" type="checkbox" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Mantenerme conectado
          </label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
      </form>
    </div>
  </div>

  