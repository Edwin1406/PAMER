
 <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Registro</h1>
                    <p class="auth-subtitle mb-4">Regístrate para obtener acceso completo.</p>

                    <form method="POST" action="/registro">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="nombre">Nombre:</label>
                            <input 
                                type="text"
                                name="nombre"
                                id="nombre"
                                class="form-control form-control-xl"
                                placeholder="Nombre">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="apellido">Apellido:</label>
                            <input 
                                type="text"
                                name="apellido"
                                id="apellido"
                                class="form-control form-control-xl"
                                placeholder="Apellido">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="email">Email:</label>
                            <input 
                                type="text"
                                name="email"
                                id="email"
                                class="form-control form-control-xl"
                                placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                    
                        
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="password">Password:</label>
                            <input 
                                type="password"
                                name="password"
                                id="password"
                                class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="password2">Confirmar Password:</label>
                            <input 
                                type="password"
                                name="password2"
                                id="password2"
                                class="form-control form-control-xl"
                                placeholder="Confirmar Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="/login"
                                class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>