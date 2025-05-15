<?php
session_start();

include __DIR__ . '/../../../backend/src/conexion_BBDD/conexion_db_pm.php';

// Usuario confirma el reemplazo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar']) && $_POST['confirmar'] === 'si') {
        if (isset($_SESSION['evento_destacado_data'])) {
            try {
                // Eliminar el evento destacado actual
                $pdo->query("UPDATE eventos SET es_destacada = 0 WHERE es_destacada = 1");

                // Nuevo evento
                $data = $_SESSION['evento_destacado_data'];
                $stmt = $pdo->prepare("INSERT INTO eventos (titulo, descripcion, fecha, id_usuario, es_destacada) VALUES (:titulo, :descripcion, :fecha, :id_usuario, :es_destacada)");
                $stmt->execute([
                    ':titulo' => $data['titulo'],
                    ':descripcion' => $data['descripcion'],
                    ':fecha' => $data['fecha'],
                    ':id_usuario' => $data['id_usuario'],
                    ':es_destacada' => $data['destacado']
                ]);

                // Limpiar sesión
                unset($_SESSION['evento_destacado_existente']);
                unset($_SESSION['evento_destacado_data']);

                // Redirigir
                header("Location: /Proyecto-Comunidad/web/src/eventos/index.php");
                exit();

            } catch (PDOException $e) {
                echo "Error al reemplazar el evento destacado: " . $e->getMessage();
            }
        }
    } else {
        // Cancelado
        unset($_SESSION['evento_destacado_existente']);
        unset($_SESSION['evento_destacado_data']);
        header("Location: /Proyecto-Comunidad/web/src/eventos/crear_evento.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar reemplazo</title>
    <link rel="stylesheet" href="../eventos/confirmar_reemplazo.css">
</head>
<body>

<header></header>

<main>
    <div class="confirm-box">
        <h2>¿Reemplazar evento destacado?</h2>
        <p>Ya existe un evento destacado. Si continúas, se eliminará el actual y se establecerá este nuevo como destacado.</p>
        <form method="POST">
            <div class="confirm-buttons">
                <button type="submit" name="confirmar" value="si" class="boton-evento">Confirmar cambio</button>
                <button type="submit" name="confirmar" value="no" class="boton-evento boton-cancelar">Cancelar</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>

