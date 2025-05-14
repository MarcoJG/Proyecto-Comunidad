<?php
    require_once __DIR__ . '/../../../config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro de la Comunidad</title>
    <link rel="stylesheet" href="<?= $basePath ?>web/src/home/home.css">
    <link rel="stylesheet" href="<?= $basePath ?>web/src/foro/foro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <script src="<?= $basePath ?>web/src/foro/foro.js" defer></script>
</head>
<body>
    <header>
        <?php
            include $_SERVER['DOCUMENT_ROOT'] . $basePath . 'web/src/header/cabecera.php';
        ?>
    </header>
    
<main class="foro-main">
    <div class="foro-principal">
            
        <div class="foro-header">
            <h2>Foro de la Comunidad</h2>
            <p>Bienvenido al foro de la comunidad. Aquí puedes discutir, hacer preguntas y compartir información con otros miembros.</p>
        </div>
        <div id="foro-content">
            <div id="foro-nuevo-hilo">
                <h3>Crear un nuevo hilo</h3>
                <input type="text" id="nuevo-hilo-titulo" placeholder="Título del hilo">
                <textarea id="nuevo-hilo-contenido" placeholder="Escribe tu mensaje"></textarea>
                <button id="enviar-hilo">Enviar</button>
            </div>
            <div id="foro-mensajes"></div>
        </div>
    </div>
    <!-- Templates -->
    <template id="hilo-template">
        <div class="hilo-foro">
            <div class="hilo-cabecera">
                <h3 class="hilo-titulo"></h3>
                <span class="autor">Publicado por <span class="hilo-autor"></span> el <span class="hilo-fecha"></span></span>
                <div class="acciones-admin">
                    <button class="borrar-hilo" data-id="" title="Borrar hilo">
                        <img src="../../../web/etc/assets/img/basura_cerrada.png" class="icon-cerrado" alt="Papelera cerrada">
                        <img src="../../../web/etc/assets/img/basura_abierta.png" class="icon-abierto" alt="Papelera abierta">
                    </button>
                    <button class="bannear-usuario" data-autor="" title="Banear usuario">
                        <img src="../../../web/etc/assets/img/persona_off.png" class="persona_off" alt="Banear"> 
                        <img src="../../../web/etc/assets/img/prohibido.png" class="icon-prohibido" alt="Banear">               
                    </button>
                    <div class="timeout-container">
                        <input type="number" placeholder="Timeout (min)" class="timeout-duration" data-autor="">
                        <button class="timeout-usuario" data-autor="" title="Expulsion temporal">
                            <img src="../../../web/etc/assets/img/alarma.png" class="icon-alarma" alt="Timeout">
                            <img src="../../../web/etc/assets/img/alarma_off.png" class="icon-alarma-off" alt="Timeout">
                        </button>
                    </div>
                </div>
            </div>
            <div class="hilo-contenido">
                <div class="hilo-contenido-texto"></div>
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
            <span class="autor-respuesta"></span> respondió el <span class="respuesta-fecha"></span>:
            <p class="respuesta-contenido"></p>
            <div class="respuesta-interacciones">
                <button class="like-respuesta-btn" data-id-respuesta="">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="likes-respuesta-count">0</span>
                </button>
                <button class="dislike-respuesta-btn" data-id-respuesta="">
                    <i class="fa fa-thumbs-down"></i>
                    <span class="dislikes-respuesta-count">0</span>
                </button>
            </div>
        </div>
    </template>
</main>    
    <footer> 
        <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe> 
    </footer>
</body>
</html>