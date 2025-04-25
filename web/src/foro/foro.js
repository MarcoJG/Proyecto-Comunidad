document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado y parseado');

    const foroMensajes = document.getElementById('foro-mensajes');
    const enviarHiloBtn = document.getElementById('enviar-hilo');
    const nuevoHiloTituloInput = document.getElementById('nuevo-hilo-titulo');
    const nuevoHiloContenidoTextarea = document.getElementById('nuevo-hilo-contenido');
    const hiloTemplate = document.getElementById('hilo-template');
    const respuestaTemplate = document.getElementById('respuesta-template');
    let hilos = [];

    function mostrarHilos() {
        foroMensajes.innerHTML = '';
        fetch('../../../backend/src/foro/obtener_hilos.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error al obtener los hilos:', data.error);
                    foroMensajes.innerHTML = '<p class="error-message">Error al cargar los hilos del foro.</p>';
                    return;
                }
                hilos = data;
                hilos.forEach(hilo => {
                    const hiloDiv = crearHiloHTML(hilo);
                    foroMensajes.appendChild(hiloDiv);
                });
                establecerEventosHilos();
            })
            .catch(error => {
                console.error('Error de red al obtener los hilos:', error);
                foroMensajes.innerHTML = '<p class="error-message">Error de red al cargar los hilos del foro.</p>';
            });
    }

    function crearHiloHTML(hilo) {
        const hiloDiv = hiloTemplate.content.cloneNode(true);
        const hiloForo = hiloDiv.querySelector('.hilo-foro');
        const hiloTitulo = hiloDiv.querySelector('.hilo-titulo');
        const hiloAutor = hiloDiv.querySelector('.hilo-autor');
        const hiloFecha = hiloDiv.querySelector('.hilo-fecha');
        const likesCount = hiloDiv.querySelector('.likes-count');
        const dislikesCount = hiloDiv.querySelector('.dislikes-count');
        const accionesAdmin = hiloDiv.querySelector('.acciones-admin');
        const borrarBtn = accionesAdmin.querySelector('.borrar-hilo');
        const bannearBtn = accionesAdmin.querySelector('.bannear-usuario');
        const timeoutContainer = accionesAdmin.querySelector('.timeout-container');
        const respuestasDiv = hiloDiv.querySelector('.hilo-respuestas');
        const responderBtn = hiloDiv.querySelector('.responder-btn');
        const nuevoRespuestaEnviar = hiloDiv.querySelector('.nuevo-respuesta .enviar-respuesta');
        const nuevoRespuestaTexto = hiloDiv.querySelector('.nuevo-respuesta .respuesta-texto');
        const likeBtn = hiloDiv.querySelector('.like-btn');
        const dislikeBtn = hiloDiv.querySelector('.dislike-btn');

        console.log('hiloDiv clonado:', hiloDiv);
        console.log('hiloForo:', hiloForo);
        console.log('hiloTitulo:', hiloTitulo);
        console.log('hiloAutor:', hiloAutor);
        console.log('hiloFecha:', hiloFecha);
        console.log('likesCount:', likesCount);
        console.log('dislikesCount:', dislikesCount);
        console.log('accionesAdmin:', accionesAdmin);
        console.log('borrarBtn:', borrarBtn);
        console.log('bannearBtn:', bannearBtn);
        console.log('timeoutContainer:', timeoutContainer);
        console.log('respuestasDiv:', respuestasDiv);
        console.log('responderBtn:', responderBtn);
        console.log('nuevoRespuestaEnviar:', nuevoRespuestaEnviar);
        console.log('nuevoRespuestaTexto:', nuevoRespuestaTexto);
        console.log('likeBtn:', likeBtn);
        console.log('dislikeBtn:', dislikeBtn);

        hiloForo.dataset.id = hilo.id;
        hiloTitulo.textContent = hilo.titulo;
        hiloAutor.textContent = hilo.autor;
        hiloFecha.textContent = formatDate(hilo.fecha);
        likesCount.textContent = hilo.likes || 0;
        dislikesCount.textContent = hilo.dislikes || 0;

        accionesAdmin.style.display = 'none';
        if (borrarBtn) {
            borrarBtn.dataset.id = hilo.id;
            accionesAdmin.style.display = 'flex';
        }
        if (bannearBtn) {
            bannearBtn.dataset.autor = hilo.autor;
            accionesAdmin.style.display = 'flex';
        }
        if (timeoutContainer) {
            timeoutContainer.dataset.autor = hilo.autor;
            accionesAdmin.style.display = 'flex';
        }

        hilo.respuestas.forEach(respuesta => {
            const respuestaDiv = respuestaTemplate.content.cloneNode(true);
            const autorRespuesta = respuestaDiv.querySelector('.autor-respuesta');
            const respuestaFecha = respuestaDiv.querySelector('.respuesta-fecha');
            const respuestaContenido = respuestaDiv.querySelector('.respuesta-contenido');

            console.log('respuestaDiv clonado:', respuestaDiv);
            console.log('autorRespuesta:', autorRespuesta);
            console.log('respuestaFecha:', respuestaFecha);
            console.log('respuestaContenido:', respuestaContenido);

            if (autorRespuesta) {
                autorRespuesta.textContent = `${respuesta.autor} respondió el`;
            }
            if (respuestaFecha) {
                respuestaFecha.textContent = formatDate(respuesta.fecha);
            }
            if (respuestaContenido) {
                respuestaContenido.textContent = respuesta.contenido;
            }

            respuestasDiv.appendChild(respuestaDiv);
            console.log('respuestaDiv insertado en respuestasDiv:', respuestaDiv);
        });

        responderBtn.dataset.id = hilo.id;
        nuevoRespuestaEnviar.dataset.id = hilo.id;
        nuevoRespuestaTexto.id = `respuesta-texto-${hilo.id}`;
        likeBtn.dataset.id = hilo.id;
        dislikeBtn.dataset.id = hilo.id;

        console.log('hiloDiv insertado en foroMensajes:', hiloDiv);
        return hiloDiv;
    }

    function establecerEventosHilos() {
        document.querySelectorAll('#foro-mensajes .like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                gestionarLikeDislike(hiloId, 'like', 'add');
            });
        });

        document.querySelectorAll('#foro-mensajes .dislike-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                gestionarLikeDislike(hiloId, 'dislike', 'add');
            });
        });

        document.querySelectorAll('#foro-mensajes .responder-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const respuestasDiv = this.closest('.hilo-foro').querySelector('.hilo-respuestas');
                respuestasDiv.style.display = respuestasDiv.style.display === 'none' ? 'block' : 'none';
            });
        });

        document.querySelectorAll('#foro-mensajes .enviar-respuesta').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                const respuestaTexto = this.closest('.hilo-foro').querySelector('.respuesta-texto').value;
                if (respuestaTexto.trim()) {
                    enviarRespuesta(hiloId, respuestaTexto);
                    this.closest('.nuevo-respuesta').querySelector('.respuesta-texto').value = '';
                }
            });
        });

        document.querySelectorAll('#foro-mensajes .borrar-hilo').forEach(btn => {
            btn.addEventListener('click', function() {
                const hiloId = parseInt(this.dataset.id);
                borrarHilo(hiloId);
            });
        });

        document.querySelectorAll('#foro-mensajes .bannear-usuario').forEach(btn => {
            btn.addEventListener('click', function() {
                const usuario = this.dataset.autor;
                fetch('../../../backend/src/foro/bannear_usuario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `usuario=${encodeURIComponent(usuario)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        mostrarHilos();
                    } else if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Error al intentar bannear al usuario.');
                    }
                })
                .catch(error => {
                    console.error('Error al bannear usuario:', error);
                    alert('Error de comunicación con el servidor al bannear.');
                });
            });
        });

        document.querySelectorAll('#foro-mensajes .timeout-usuario').forEach(btn => {
            btn.addEventListener('click', function() {
                const usuario = this.closest('.acciones-admin').dataset.autor;
                const duracionInput = this.closest('.acciones-admin').querySelector('.timeout-duration');
                const duracion = duracionInput ? duracionInput.value : '';

                if (duracion.trim()) {
                    fetch('../../../backend/src/foro/timeout_usuario.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `usuario=${encodeURIComponent(usuario)}&duracion=${encodeURIComponent(duracion)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            mostrarHilos();
                        } else if (data.error) {
                            alert(data.error);
                        } else {
                            alert('Error al aplicar timeout al usuario.');
                        }
                    })
                    .catch(error => {
                        console.error('Error al aplicar timeout:', error);
                        alert('Error de comunicación con el servidor al aplicar timeout.');
                    });
                } else {
                    alert('Por favor, introduce una duración para el timeout (en minutos).');
                }
            });
        });
    }

    enviarHiloBtn.addEventListener('click', function() {
        console.log('Botón de enviar presionado');
        const titulo = nuevoHiloTituloInput.value;
        const contenido = nuevoHiloContenidoTextarea.value;
        if (titulo.trim() && contenido.trim()) {
            const data = `titulo=${encodeURIComponent(titulo)}&contenido=${encodeURIComponent(contenido)}`;
            console.log('Datos a enviar (antes de fetch):', data);
            fetch('../../../backend/src/foro/crear_hilo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data
            })
            .then(response => {
                console.log('Respuesta completa (antes de .json()):', response);
                console.log('response.ok:', response.ok);
                console.log('response.headers.get(\'Content-Type\'):', response.headers.get('Content-Type'));
                if (!response.ok) {
                    throw new Error('Error en la petición: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Datos JSON recibidos:', data);
                if (data.success) {
                    console.log('Hilo creado con éxito');
                    nuevoHiloTituloInput.value = '';
                    nuevoHiloContenidoTextarea.value = '';
                    mostrarHilos();
                } else if (data.error) {
                    console.log('Error del servidor:', data.error);
                    alert(data.error);
                } else {
                    console.log('Error desconocido al crear el hilo');
                    alert('Error al crear el hilo.');
                }
            })
            .catch(error => {
                console.error('Error de fetch:', error);
                console.error('Error detallado:', error.message);
                alert('Error de comunicación con el servidor al crear el hilo.');
            });
        } else {
            alert('Por favor, introduce un título y un contenido para el hilo.');
        }
    });

    function gestionarLikeDislike(hiloId, accion, tipo) {
        fetch('../../../backend/src/foro/gestionar_like_dislike.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_hilo=${encodeURIComponent(hiloId)}&accion=${encodeURIComponent(accion)}&tipo=${encodeURIComponent(tipo)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || data.info) {
                mostrarHilos();
            } else if (data.error) {
                alert(data.error);
            } else {
                alert(`Error al ${accion}.`);
            }
        })
        .catch(error => {
            console.error(`Error al ${accion}:`, error);
            alert(`Error de comunicación con el servidor al ${accion}.`);
        });
    }

    function enviarRespuesta(hiloId, contenido) {
        fetch('../../../backend/src/foro/enviar_respuesta.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_hilo=${encodeURIComponent(hiloId)}&contenido=${encodeURIComponent(contenido)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarHilos();
            } else if (data.error) {
                alert(data.error);
            } else {
                alert('Error al enviar la respuesta.');
            }
        })
        .catch(error => {
            console.error('Error al enviar la respuesta:', error);
            alert('Error de comunicación con el servidor al enviar la respuesta.');
        });
    }

    function borrarHilo(hiloId) {
        if (confirm('¿Estás seguro de que quieres borrar este hilo?')) {
            fetch('../../../backend/src/foro/borrar_hilo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id_hilo=${encodeURIComponent(hiloId)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarHilos();
                } else if (data.error) {
                    alert(data.error);
                } else {
                    alert('Error al borrar el hilo.');
                }
            })
            .catch(error => {
                console.error('Error al borrar el hilo:', error);
                alert('Error de comunicación con el servidor al borrar el hilo.');
            });
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return date.toLocaleDateString('es-ES', options);
    }

    mostrarHilos();
});