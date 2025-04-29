<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="stylesheet" href="generico.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <?php
            define('BASE_PATH', '../header/');
            include(BASE_PATH . 'cabecera.php');
        ?>
    </header>
    <div class="container">
        <div class="contact-info">
            <h2>Contacta con nosotros</h2>
            <p>Estaremos encantados de atenderte desde nuestro formulario de contacto o directamente desde nuestros datos de contacto. Te responderemos lo antes posible.</p>
            
            <h2>Datos de contacto:</h2>
            <p class="correo-contacto">soporteproyectocomunidad@gmail.com</p>
            <div class="social-icons">
                <a href="#" aria-label="Twitter"><i class="fab fa-x"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>

        <div class="contact-form">
            <h2>Formulario de contacto</h2>
            <form id="formularioContacto" action="../../../backend/src/contacto/enviar_correo.php" method="POST">
            <div class="form-group">
                <div class="form-field">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Nombre">
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@email.com">
                </div>
            </div>
            <div>
                <label class="mensaje-label"for="message">Mensaje</label>
                <textarea id="message" class="textarea-grande" name="message" placeholder="Cualquier cosa que nos quieras comunicar"></textarea>
            </div>
            <button class="boton_secundario" type="submit">Enviar</button>
            </form>
            <span id="mensajeResultado"></span>
            <span id="erroresValidacion"></span>
        </div>
        
    </div>

    <script src="index.js" ></script>
    
    <footer> 
        <iframe src="../footer/FOOTER.html" frameborder="0" width="100%" height="300px"></iframe> 
    </footer>
</body>
</html>