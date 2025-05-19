<?php
session_start();

include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

// Usuario confirma el reemplazo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar']) && $_POST['confirmar'] === 'si') {
        if (isset($_SESSION['noticia_destacado_data'])) {
            try {
                // Eliminar el noticia destacado actual
                $pdo->query("UPDATE noticias SET es_destacada = 0 WHERE es_destacada = 1");

                // Nuevo noticia
                $data = $_SESSION['noticia_destacado_data'];
                $stmt = $pdo->prepare("INSERT INTO noticias (titulo, contenido, fecha, id_usuario, es_destacada) VALUES (:titulo, :contenido, :fecha, :id_usuario, :es_destacada)");
                $stmt->execute([
                    ':titulo' => $data['titulo'],
                    ':contenido' => $data['contenido'],
                    ':fecha' => $data['fecha'],
                    ':id_usuario' => $data['id_usuario'],
                    ':es_destacada' => $data['destacado']
                ]);

                // Limpiar sesión
                unset($_SESSION['noticia_destacado_existente']);
                unset($_SESSION['noticia_destacado_data']);

                // Redirigir
                header("Location: /Proyecto-Comunidad/web/src/noticias/index.php");
                exit();

            } catch (PDOException $e) {
                echo "Error al reemplazar el noticia destacado: " . $e->getMessage();
            }
        }
    } else {
        // Cancelado
        unset($_SESSION['noticia_destacado_existente']);
        unset($_SESSION['noticia_destacado_data']);
        header("Location: /Proyecto-Comunidad/web/src/noticias/crear_noticia.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar reemplazo</title>
    <link rel="stylesheet" href="../noticias/confirmar_reemplazo.css">
</head>
<body>

<header></header>

<main>
    <div class="confirm-box">
        <h2>¿Reemplazar noticia destacado?</h2>
        <p>Ya existe un noticia destacado. Si continúas, se eliminará el actual y se establecerá este nuevo como destacado.</p>
        <form method="POST">
            <div class="confirm-buttons">
                <button type="submit" name="confirmar" value="si" class="boton-noticia">Confirmar cambio</button>
                <button type="submit" name="confirmar" value="no" class="boton-noticia boton-cancelar">Cancelar</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>

