document.addEventListener('DOMContentLoaded', function () {
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
            .catch(() => {
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
        const nuevoRespuestaDiv = hiloDiv.querySelector('.nuevo-respuesta');
        const nuevoRespuestaEnviar = nuevoRespuestaDiv.querySelector('.enviar-respuesta');
        const nuevoRespuestaTexto = nuevoRespuestaDiv.querySelector('.respuesta-texto');
        const likeBtn = hiloDiv.querySelector('.like-btn');
        const dislikeBtn = hiloDiv.querySelector('.dislike-btn');

        hiloForo.dataset.id = hilo.id;
        hiloTitulo.textContent = hilo.titulo;
        hiloAutor.textContent = hilo.autor;
        hiloFecha.textContent = formatDate(hilo.fecha);
        likesCount.textContent = hilo.likes || 0;
        dislikesCount.textContent = hilo.dislikes || 0;

        // LÍNEA AÑADIDA: mostrar contenido del hilo
        const contenidoElemento = hiloDiv.querySelector('.hilo-contenido-texto');
        if (contenidoElemento) contenidoElemento.innerHTML = hilo.contenido;

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

            if (autorRespuesta) {
                autorRespuesta.textContent = `${respuesta.autor} respondió el`;
            }
            if (respuestaFecha) {
                respuestaFecha.textContent = formatDate(respuesta.fecha);
            }
            if (respuestaContenido) {
                respuestaContenido.textContent = respuesta.contenido;
            }

            // NUEVO: Like/dislike en respuestas
            const respuestaId = respuesta.id;
            const respuestaContainer = respuestaDiv.querySelector('.respuesta');
            const likeRespuestaBtn = respuestaDiv.querySelector('.like-respuesta-btn');
            const dislikeRespuestaBtn = respuestaDiv.querySelector('.dislike-respuesta-btn');
            const likesRespuestaCount = respuestaDiv.querySelector('.likes-respuesta-count');
            const dislikesRespuestaCount = respuestaDiv.querySelector('.dislikes-respuesta-count');

            if (likeRespuestaBtn && dislikeRespuestaBtn) {
                likeRespuestaBtn.dataset.id = respuestaId;
                dislikeRespuestaBtn.dataset.id = respuestaId;
            }
            if (likesRespuestaCount) likesRespuestaCount.textContent = respuesta.likes || 0;
            if (dislikesRespuestaCount) dislikesRespuestaCount.textContent = respuesta.dislikes || 0;

            respuestasDiv.appendChild(respuestaDiv);
        });

        responderBtn.dataset.id = hilo.id;
        nuevoRespuestaEnviar.dataset.id = hilo.id;
        nuevoRespuestaTexto.id = `respuesta-texto-${hilo.id}`;
        likeBtn.dataset.id = hilo.id;
        dislikeBtn.dataset.id = hilo.id;

        return hiloDiv;
    }

    function establecerEventosHilos() {
        document.querySelectorAll('#foro-mensajes .like-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const hiloId = parseInt(this.dataset.id);
                gestionarLikeDislike(hiloId, 'like', 'add');
            });
        });

        document.querySelectorAll('#foro-mensajes .dislike-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const hiloId = parseInt(this.dataset.id);
                gestionarLikeDislike(hiloId, 'dislike', 'add');
            });
        });

        document.querySelectorAll('#foro-mensajes .responder-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const respuestasDiv = this.closest('.hilo-foro').querySelector('.hilo-respuestas');
                respuestasDiv.style.display = respuestasDiv.style.display === 'none' ? 'block' : 'none';
            });
        });

        document.querySelectorAll('#foro-mensajes .enviar-respuesta').forEach(btn => {
            btn.addEventListener('click', function () {
                const hiloId = parseInt(this.dataset.id);
                const respuestaTexto = this.closest('.nuevo-respuesta').querySelector('.respuesta-texto').value;
                if (respuestaTexto.trim()) {
                    enviarRespuesta(hiloId, respuestaTexto);
                    this.closest('.nuevo-respuesta').querySelector('.respuesta-texto').value = '';
                }
            });
        });

        document.querySelectorAll('#foro-mensajes .borrar-hilo').forEach(btn => {
            btn.addEventListener('click', function () {
                const hiloId = parseInt(this.dataset.id);
                borrarHilo(hiloId);
            });
        });

        document.querySelectorAll('#foro-mensajes .bannear-usuario').forEach(btn => {
            btn.addEventListener('click', function () {
                const usuario = this.dataset.autor;
                fetch('../../../backend/src/foro/bannear_usuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `usuario=${encodeURIComponent(usuario)}`
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            mostrarHilos();
                        } else {
                            alert(data.error || 'Error al intentar bannear al usuario.');
                        }
                    });
            });
        });

        document.querySelectorAll('#foro-mensajes .timeout-usuario').forEach(btn => {
            btn.addEventListener('click', function () {
                const accionesAdmin = this.closest('.acciones-admin');
                const usuario = accionesAdmin.dataset.autor;
                const duracion = accionesAdmin.querySelector('.timeout-duration')?.value;

                if (duracion?.trim()) {
                    fetch('../../../backend/src/foro/timeout_usuario.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `usuario=${encodeURIComponent(usuario)}&duracion=${encodeURIComponent(duracion)}`
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.success);
                                mostrarHilos();
                            } else {
                                alert(data.error || 'Error al aplicar timeout al usuario.');
                            }
                        });
                } else {
                    alert('Por favor, introduce una duración para el timeout (en minutos).');
                }
            });
        });

        // MODIFICADO: eventos like/dislike en respuestas
        document.querySelectorAll('#foro-mensajes .like-respuesta-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const respuestaId = parseInt(this.dataset.id);
                gestionarLikeDislikeRespuesta(this, respuestaId, 'like', 'add');
            });
        });

        document.querySelectorAll('#foro-mensajes .dislike-respuesta-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const respuestaId = parseInt(this.dataset.id);
                gestionarLikeDislikeRespuesta(this, respuestaId, 'dislike', 'add');
            });
        });
    }

    enviarHiloBtn.addEventListener('click', function () {
        const titulo = nuevoHiloTituloInput.value;
        const contenido = nuevoHiloContenidoTextarea.value;
        if (titulo.trim() && contenido.trim()) {
            const data = `titulo=${encodeURIComponent(titulo)}&contenido=${encodeURIComponent(contenido)}`;
            fetch('../../../backend/src/foro/crear_hilo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        nuevoHiloTituloInput.value = '';
                        nuevoHiloContenidoTextarea.value = '';
                        mostrarHilos();
                    } else {
                        alert(data.error || 'Error al crear el hilo.');
                    }
                })
                .catch(() => alert('Error de comunicación con el servidor al crear el hilo.'));
        } else {
            alert('Por favor, introduce un título y un contenido para el hilo.');
        }
    });

    function gestionarLikeDislike(hiloId, accion, tipo) {
        fetch('../../../backend/src/foro/gestionar_like_dislike.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_hilo=${encodeURIComponent(hiloId)}&accion=${encodeURIComponent(accion)}&tipo=${encodeURIComponent(tipo)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.info) {
                    mostrarHilos();
                } else {
                    alert(data.error || `Error al ${accion}.`);
                }
            })
            .catch(() => alert(`Error de comunicación con el servidor al ${accion}.`));
    }

    function gestionarLikeDislikeRespuesta(respuestaId, accion, tipo) {
        fetch('../../../backend/src/foro/gestionar_like_dislike_respuesta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_respuesta=${encodeURIComponent(respuestaId)}&accion=${encodeURIComponent(accion)}&tipo=${encodeURIComponent(tipo)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const respuestaElement = document.querySelector(`.like-respuesta-btn[data-id="${respuestaId}"]`)?.closest('.respuesta');
                    if (respuestaElement) {
                        const likesSpan = respuestaElement.querySelector('.likes-respuesta-count');
                        const dislikesSpan = respuestaElement.querySelector('.dislikes-respuesta-count');
                        if (likesSpan) likesSpan.textContent = data.likes;
                        if (dislikesSpan) dislikesSpan.textContent = data.dislikes;
                    }
                } else if (data.info) {
                    alert(data.info);
                } else {
                    alert(data.error || `Error al ${accion} en respuesta.`);
                }
            })
            .catch(() => alert(`Error de comunicación con el servidor al ${accion} en respuesta.`));
    }

    function enviarRespuesta(hiloId, contenido) {
        fetch('../../../backend/src/foro/enviar_respuesta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_hilo=${encodeURIComponent(hiloId)}&contenido=${encodeURIComponent(contenido)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarHilos();
                } else {
                    alert(data.error || 'Error al enviar la respuesta.');
                }
            })
            .catch(() => alert('Error de comunicación con el servidor al enviar la respuesta.'));
    }

    function borrarHilo(hiloId) {
        if (confirm('¿Estás seguro de que quieres borrar este hilo?')) {
            fetch('../../../backend/src/foro/borrar_hilo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_hilo=${encodeURIComponent(hiloId)}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarHilos();
                    } else {
                        alert(data.error || 'Error al borrar el hilo.');
                    }
                })
                .catch(() => alert('Error de comunicación con el servidor al borrar el hilo.'));
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    mostrarHilos();
});