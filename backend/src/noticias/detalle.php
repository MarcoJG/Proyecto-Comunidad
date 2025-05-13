<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $id_noticias = (int) $_GET['id']; // Validación estricta

    // Consulta segura con prepared statement
    $sql = "SELECT * FROM noticias WHERE id_noticias = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id_noticias]);

    if ($stmt->rowCount() > 0) {
        $noticia = $stmt->fetch();

        // Escapar contenido para prevenir XSS
        $titulo = htmlspecialchars($noticia['titulo'], ENT_QUOTES, 'UTF-8');
        $fecha = date('d/m/Y', strtotime($noticia['fecha']));
        $contenido = htmlspecialchars($noticia['contenido'], ENT_QUOTES, 'UTF-8');

        echo 
            "<div class='noticia-header'>
                <div class='noticia-imagen'>
                    <img src='../../etc/assets/img/bloque.jpg' alt='Imagen de la noticia'>
                </div>
                <div class='noticia-info'>
                    <h2 class='titulo-noticia'>{$titulo}</h2>
                    <p class='detalle-noticia'>{$fecha}</p>
                </div>
            </div>
            <div class='descripcion-noticia'>
                <p>{$contenido}</p>
            <style>
                            .btn-borrar img {
                                width: 20px;
                                height: 20px;
                                margin-right: 8px;
                            }
                            .btn-borrar .icon-abierto {
                                display: none;
                            }
                            .btn-borrar:hover .icon-cerrado {
                                display: none;
                            }
                            .btn-borrar:hover .icon-abierto {
                                display: inline;
                                scale : 1.2;
                            }
                            .contenedor-boton {
                                text-align: right;
                                margin-top: 10px;
                            }
                            .contenedor-boton form {
                                display: inline-block;
                            }
                    </style>
                <div class='contenedor-boton'>        
                    <form method='POST' action='../../../backend/src/noticias/eliminar_noticia.php' onsubmit='return confirm(\"¿Estás seguro de que quieres borrar esta noticia?\");'>
                        <input type='hidden' name='id_noticias' value='$id_noticias'>
                        <button type='submit' class='btn-borrar' title='Eliminar noticia'
                            style='margin-top:20px; background-color: #ffffff; color:white; padding:10px 20px; border:none; cursor:pointer; display: flex; align-items: center;'>
                        
                            <img src='../../../web/etc/assets/img/basura_cerrada.png' class='icon-cerrado' alt='Papelera cerrada'>
                                
                            <img src='../../../web/etc/assets/img/basura_abierta.png' class='icon-abierto' alt='Papelera abierta'>
                        
                        </button>
                    </form>
                </div>    
            </div>";
    } else {
        echo "<p>Noticia no encontrada.</p>";
    }
} else {
    echo "<p>ID de la noticia no proporcionado o inválido.</p>";
}
?>
