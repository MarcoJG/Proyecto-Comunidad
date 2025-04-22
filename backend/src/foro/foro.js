document.addEventListener('DOMContentLoaded', function() {
    const foroMensajes = document.getElementById('foro-mensajes');
    const enviarHiloBtn = document.getElementById('enviar-hilo');
    const nuevoHiloTituloInput = document.getElementById('nuevo-hilo-titulo');
    const nuevoHiloContenidoTextarea = document.getElementById('nuevo-hilo-contenido');
    const hiloTemplate = document.getElementById('hilo-template');
    const respuestaTemplate = document.getElementById('respuesta-template');

    let hilos = [
        {id: 1, titulo: 'Bienvenid@ al foro', contenido: 'Bienvenido todos al nuevo foro de la Comunidad!', autor: 'Admin',
        fecha: '22/04/2025', likes: 5, dislikes: 0, respuestas: []},
        {id: 2, titulo: 'Duda sobre la piscina', contenido: '¿Alguien sabe cuándo se abre la piscina este año?',
        autor: 'Usuario1', fecha: '21/04/2025', likes: 2, dislikes: 1, 
        respuestas: [{autor: 'Presidente', fecha: '21/04/2025', contenido: 'Se espera que abra el 1 de Junio.'}]}
    ];

    function mostrarHilos(){
        foroMensajes.innerHTML = '';
        hilos.forEach(hilo => {
            const hiloDiv = crearHiloHTML(hilo);
            foroMensajes.appendChild(hiloDiv);
        });
        establecerEventosHilos();
    }

    function crearHiloHTML(hilo){
        const hiloDiv = hiloTemplate.contentEditable.cloneNode(true);
        hiloDiv.querySelector('.hilo-foro').dataset.id = hilo.id;
        hiloDiv.querySelector('.hilo-titulo').textContent = hilo.titulo;
        hiloDiv.querySelector('.hilo-autor').textContent = hilo.autor;
        hiloDiv.querySelector('.hilo-fecha').textContent = hilo.fecha;
        hiloDiv.querySelector('.likes-count').textContent = hilo.likes;
        hiloDiv.querySelector('.dislikes-count').textContent = hilo.dislikes;

        const accionesAdmin = hiloDiv.querySelector('.acciones-admin');
        if(obtenerRolUsuario() === 'Admin' || obtenerRolUsuario() === 'Presidente'){
            accionesAdmin.style.display = 'flex';
            accionesAdmin.style.querySelector('.borrar-hilo').dataset.id = hilo.id;
            if (obtenerRolUsuario() === 'Admin') {
                accionesAdmin.querySelector('.bannear-usuario').dataset.autor = hilo.autor;
                accionesAdmin.querySelector('.timeout-duracion').dataset.autor = hilo.autor;
                accionesAdmin.querySelector('.timeout-usuario').dataset.autor = hilo.autor;
            } else {
                const adminElements = accionesAdmin.querySelectorAll('.bannear-usuario, .timeout-duracion, .timeout-usuario');
                adminElements.forEach(el => el.remove());
            }
        }
        const respuestasDiv = hiloDiv.querySelector('.hilo-respuestas');
        hilo.respuestas.forEach(respuesta => {
            const respuestaDiv = respuestaTemplate.contentEditable.cloneNode(true);
            respuestaDiv.querySelector('.autor-respuesta').textContent = `${respuesta.autor} respondió el`;
            respuestaDiv.querySelector('.respuesta-fecha').textContent = respuesta.fecha;
            respuestaDiv.querySelector('.respuesta-contenido').textContent = respuesta.contenido;
            respuestasDiv.appendChild(respuestaDiv);
        });
        hiloDiv.querySelector('.responder-btn').dataset.id = hilo.id;
        hiloDiv.querySelector('.nuevo-respuesta .enviar-respuesta').dataset.id = hilo.id;
        hiloDiv.querySelector('.nuevo-respuesta .respuesta-texto').id = `respuesta-texto-${hilo.id}`;
        hiloDiv.querySelector('.like-btn').dataset.id = hilo.id;
        hiloDiv.querySelector('.dislike-btn').dataset.id = hilo.id;

        return hiloDiv;
    }

    function establecerEventosHilos(){
        document.querySelectorAll('#foro-mensajes .like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                const hilo = hilos.find(h => h.id === hiloId);
                if (hilo) hilo.dislikes++;
                mostrarHilos();
            });
        });
        document.querySelectorAll('#foro-mensajes .dislike-btn').forEach(btn => {
            btn.addEventListener('click', function(){
                const hiloId = parseInt(this.dataset.id);
                const hilo = hilos.find(h => h.id === hiloId);
                if (hilo) hilo.dislikes++;
                mostrarHilos();
            });
        });
        document.querySelectorAll('#foro-mensajes .responder-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                const respuestasDiv = this.closest('.hilo-foro').querySelector('.hilo-respuestas');
                respuestasDiv.style.display = respuestasDiv.style.display === 'none' ? 'block' : 'none';
            });
        });
        document.querySelectorAll('#foro-mensajes .enviar-respuesta').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                const respuestaTexto = this.closest('.hilo-foro').querySelector('.respuesta-texto').value;
                if (respuestaTexto.trim()) {
                    const hilo = hilos.find(h => h.id === hiloId);
                    if (hilo) {
                        hilos.respuestas.push({autor: obtenerRolUsuario(), fecha: new Date().toLocaleDateString(),
                                               contenido: respuestaTexto });
                        this.closest('.nuevo-respuesta').querySelector('.respuesta-texto').value = '';
                        mostrarHilos();
                    }
                }
            });
        });
        document.querySelectorAll('#foro-mensajes .borrar-hilo').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                hilos = hilos.filter(h => h.id !== hiloId);
                mostrarHilos();
            });
        });
        document.querySelectorAll('#foro-mensajes .bannear-usuario').forEach(btn => {
            btn.addEventListener('click', function() {
                const usuario = this.dataset.autor;
                alert(`Usuario ${usuario} banneado.`);
            });
        });
        document.querySelectorAll('#foro-mensajes .timeout-usuario').forEach(btn => {
            btn.addEventListener('click', function() {
                const usuario = this.dataset.autor;
                const duracion = this.closest('.acciones-admin').querySelector('.timeout-duracion').value;
                alert(`Timeout de ${duracion} minutos aplicado a ${usuario}.`);
            });
        });
    }
    enviarHiloBtn.addEventListener('click', function() {
        const titulo = nuevoHiloTituloInput.value;
        const contenido = nuevoHiloContenidoTextarea.value;
        if (titulo.trim() && contenido.trim()) {
            const nuevoHilo = {
                id: Date.now(),
                titulo: titulo,
                contenido: contenido,
                autor: obtenerRolUsuario(),
                fecha: new Date().toLocaleDateString(),
                likes: 0,
                dislikes: 0,
                respuestas: []
            };
            hilos.unshift(nuevoHilo);
            nuevoHiloTituloInput.value = '';
            nuevoHiloContenidoTextarea.value = '';
            mostrarHilos();
        }
    });
    function obtenerRolUsuario(){
        const roles = ["Usuario", "Admin", "Presidente"];
        return roles[Math.floor(Math.random() * roles.length)];
    }
    mostrarHilos();
});