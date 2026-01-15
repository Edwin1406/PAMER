<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?? '' ?></h2>
    <p class="auth__texto">Ingresa tu nueva contraseña </p>
    <?php require_once __DIR__. '/../templates/alertas.php'; ?>


    <?php if ($token_valido) :?>
    <form  method="POST"  class="formulario">
        <div class="formulario__campo">
            <label for="password"  class="formulario__label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="formulario__input" 
                placeholder="Tu password" 
                id="password"
                >
        </div>
        <input type="submit" value="Cambiar contraseña" class="formulario__submit">
    </form>

    <?php endif; ?>

    <div class="acciones">
        <a href="/" class="acciones__enlace">Ya tienes cuenta ? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">Crear Cuenta</a>
    </div>
</main>