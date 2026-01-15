(function() {

    const alertaCotizador = document.querySelector('div .exito');
    if(alertaCotizador) {
        setTimeout(() => {
            alertaCotizador.remove();
        }, 3000);
    }


})();