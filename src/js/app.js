(function(){
    const maquinaInput = document.querySelector('#maquina_id');
    if(maquinaInput){
        let maquinas= [];
        let maquinasFiltradas = [];

        const listadoMaquinas = document.querySelector('#listado-maquinas');
        obtenerMaquinas();

        maquinaInput.addEventListener('input',buscarMaquinas);

        async function obtenerMaquinas(){
            const url = `${location.origin}/admin/api/maquinas`;;
            const respuesta = await fetch(url);
            resultado = await respuesta.json();
            formatearMaquinas(resultado);
        }


        function formatearMaquinas(arrayMaquinas=[]){
            maquinas = arrayMaquinas.map(maquina => {
                return {
                    nombre: `${maquina.nombre.trim()}`,
                    id: maquina.id
                }
            });

            console.log(maquinas);

        }


        function buscarMaquinas(e){
           const busqueda = e.target.value;

           if(busqueda.length>3){
            const expresion = new RegExp(busqueda, 'i');
            maquinasFiltradas = maquinas.filter(maquina =>{
                if(maquina.nombre.toLowerCase().search(expresion) != -1){
                    return maquina;

                }
            });
           }else{
                maquinasFiltradas = [];
           }
           mostrarMaquinas();
        }

        function mostrarMaquinas(){
            while(listadoMaquinas.firstChild){
                listadoMaquinas.removeChild(listadoMaquinas.firstChild);
            }

            if(maquinasFiltradas.length >0){
                maquinasFiltradas.forEach (maquina =>{
                    const maquinaHTML = document.createElement('LI');
                    maquinaHTML.classList.add('listado-maquinas__maquina');
                    maquinaHTML.textContent = maquina.nombre;
                    maquinaHTML.dataset.id = maquina.id;
    
                    // anadir al html
                    listadoMaquinas.appendChild(maquinaHTML);
                })

            }else{
                const noResultado = document.createElement('P');
                noResultado.classList.add('listado-maquinas__no-resultado');
                noResultado.textContent = 'No hay resultados';
                listadoMaquinas.appendChild(noResultado);
            }



          
        }

    }
})();

