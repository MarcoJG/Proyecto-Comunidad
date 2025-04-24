<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro de la Comunidad</title>
    <link rel="stylesheet" href="../home/home.css">
    <link rel="stylesheet" href="foro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <script src="../../../backend/src/foro/foro.js"></script>
</head>
<body>
    <header>
        <iframe src="../header/cabecera.html" frameborder="0" width="100%" height="100%"></iframe>
    </header>
    <main id="foro-content">
        <h2>Foro de la Comunidad</h2>
        <div id="foro-mensajes">
            </div>
        <div id="foro-nuevo-hilo">
            <h3>Crear un nuevo hilo</h3>
            <input type="text" id="nuevo-hilo-titulo" placeholder="Título del hilo">
            <textarea id="nuevo-hilo-contenido" placeholder="Escribe tu mensaje"></textarea>
            <button id="enviar-hilo">Enviar</button>
        </div>
    </main>
    <template id="hilo-template">
        <div class="hilo-foro">
            <div class="hilo-cabecera">
                <h3 class="hilo-titulo"></h3>
                <span class="autor">Publicado por <span class="hilo-autor"></span>el <span class="hilo-fecha"></span></span>
                <div class="acciones-admin" style="display: none; gap: 10px; align-items: center;">
                    <button class="borrar-hilo" data-id="">Borrar</button>
                    <button class="bannear-usuario" data-autor="">Bannear</button>
                    <input type="number" placeholder="Timeout (min)" class="timeout-duration" data-autor="">
                    <button class="timeout-usuario" data-autor="">Timeout</button>
                </div>
            </div>
            <div class="hilo-contenido">
                <p class="hilo-contenido-texto"></p>
            </div>
            <div class="hilo-interacciones">
                <button class="like-btn" data-id=""><i class="fa fa-thumbs-up"></i>
                <span class="likes-count">0</span></button>
                <button class="dislike-btn" data-id=""><i class="fa fa-thumbs-down"></i>
                <span class="dislikes-count">0</span></button>
                <button class="responder-btn" data-id="">Responder</button>
            </div>
            <div class="hilo-respuestas" style="display: none;">
                <div class="nuevo-respuesta">
                    <textarea placeholder="Escribe tu respuesta" class="respuesta-texto"></textarea>
                    <button class="enviar-respuesta" data-id="">Enviar</button>
                </div>
            </div>
        </div>
    </template>
    <template id="respuesta-template">
        <div class="respuesta">
            <span class="autor-respuesta"> respondió el <span class="respuesta-fecha"></span>:</span>
            <p class="respuesta-contenido"></p>
            <div class="respuesta-interacciones">
                <button class="like-respuesta-btn"><i class="fa fa-thumbs-up"></i>
                <span class="likes-count">0</span></button>
                <button class="dislike-respuesta-btn"><i class="fa fa-thumbs-down">
                <span class="dislikes-count">0</span></i></button>
            </div>
        </div>
    </template>
</body>
</html>