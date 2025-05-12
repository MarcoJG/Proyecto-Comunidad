<?php

include __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

if (isset($_GET['id'])) {
    $id_evento = intval($_GET['id']); // Evitar inyecciones

    $sql = "SELECT * FROM eventos WHERE id_evento = $id_evento";
    $resultado = $pdo->query($sql);

    if ($resultado->rowCount() > 0) {
        $evento = $resultado->fetch();
        echo 
            "<div class='evento-header'>
                <div class='evento-imagen'>
                    <img src='../../etc/assets/img/bloque.jpg' alt='Imagen del evento'>
                </div>
                <div class='evento-info'>
                    <h2 class='titulo-evento'>" . $evento['titulo'] . "</h2>
                    <p class='detalle-evento'>" . date('d/m/Y', strtotime($evento['fecha'])) . "</p>
                </div>
            </div>
            <div class='descripcion-evento'>
                <p>" . $evento['descripcion'] . "</p>

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
                    <form method='POST' action='../../../backend/src/eventos/eliminar_evento.php' onsubmit='return confirm(\"¿Estás seguro de que quieres borrar este evento?\");'>
                        <input type='hidden' name='id_evento' value='$id_evento'>
                        <button type='submit' class='btn-borrar' title='Eliminar evento'
                            style='margin-top:20px; background-color: #ffffff; color:white; padding:10px 20px; border:none; cursor:pointer; display: flex; align-items: center;'>
                        
                            <img src='../../../web/etc/assets/img/basura_cerrada.png' class='icon-cerrado' alt='Papelera cerrada'>
                                
                            <img src='../../../web/etc/assets/img/basura_abierta.png' class='icon-abierto' alt='Papelera abierta'>
                        
                        </button>
                    </form>
                </div>    
            </div>";
    } else {
        echo "<p>Evento no encontrado.</p>";
    }
} else {
    echo "<p>ID del evento no proporcionado.</p>";
}
?>
