<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo ?? '' ?></h2>
    <p class="auth__texto">Recupera tu acceso a Sitio Web </p>
    <?php require_once __DIR__. '/../templates/alertas.php'; ?>

    <form  method="POST" action="/sitioweb/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email"  class="formulario__label">Email</label>
            <input 
                type="email" 
                name="email" 
                class="formulario__input" 
                placeholder="Tu Email" 
                id="email"
                >
        </div>
        <input type="submit" value="Enviar Istrucciones" class="formulario__submit">
    </form>
    <div class="acciones">
        <a href="/" class="acciones__enlace">Ya tienes cuenta ? Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">Crear Cuenta</a>
    </div>
</main>