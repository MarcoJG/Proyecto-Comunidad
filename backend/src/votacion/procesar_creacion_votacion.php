<?php
session_start(); // Inicia la sesión al principio para acceder a $_SESSION

// Asegúrate de que esta ruta sea correcta para tu archivo de conexión.
// Si tu 'procesar_creacion_votacion.php' está en 'src/votacion/'
// y tu 'conexion_db_pm.php' está en 'src/conexion_BBDD/',
// entonces 'require_once("../conexion_BBDD/conexion_db_pm.php");' es correcto.
require_once __DIR__ . '/../conexion_BBDD/conexion_db_pm.php';

// DESACTIVAMOS LOGIN TEMPORALMENTE (si es tu intención para pruebas)
// if (!isset($_SESSION['id_usuario'])) {
//     header("Location: ../../../web/src/login/index.php");
//     exit();
// }

// Verifica si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger y sanear los datos del formulario
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $opciones = $_POST['opciones'] ?? []; // Esto es un array de las opciones
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';

    // ID DE USUARIO FIJO PARA PRUEBAS (similar a tu script de reservas)
    // Cuando habilites el login, deberías usar: $id_usuario = $_SESSION['id_usuario'] ?? null;
    $id_usuario = 1; // Asume un ID de usuario válido para pruebas

    // Validaciones básicas de campos
    // También validamos que id_usuario no sea nulo si decides no usar un ID fijo
    if (empty($titulo) || count($opciones) < 2 || empty($fecha_inicio) || empty($fecha_fin) || $id_usuario === null) {
        // Redirige con un mensaje de error si faltan datos
        header('Location: ../../../web/src/votacion/crear_votacion.php?error=campos_incompletos');
        exit();
    }

    // Filtra y asegura que las opciones no estén vacías y sean únicas
    $opciones_filtradas = array_filter(array_map('trim', $opciones), 'strlen');
    $opciones_unicas = array_unique($opciones_filtradas);

    if (count($opciones_unicas) < 2) {
        header('Location: ../../../web/src/votacion/crear_votacion.php?error=minimo_dos_opciones');
        exit();
    }
    
    // Validar que la fecha de fin no sea anterior o igual a la de inicio
    if (strtotime($fecha_fin) <= strtotime(date('Y-m-d H:i:s'))) {
        header('Location: ../../../web/src/votacion/crear_votacion.php?error=fecha_inicio_pasada');
        exit();
    }

    if (strtotime($fecha_fin) <= strtotime($fecha_inicio)) {
        header('Location: ../../../web/src/votacion/crear_votacion.php?error=fecha_fin_invalida');
        exit();
    }

    try {
        // Iniciar una transacción para asegurar que todas las inserciones sean exitosas
        // o ninguna de ellas, manteniendo la integridad de la base de datos.
        $pdo->beginTransaction();

        // Insertar la votación principal en la tabla `votacion`
        // Usamos prepared statements para mayor seguridad y eficiencia
        $stmt_votacion = $pdo->prepare(
            "INSERT INTO votacion (titulo, descripcion, fecha_inicio, fecha_fin, id_usuario) 
             VALUES (?, ?, ?, ?, ?)"
        );
        // Ejecutar la consulta con los datos
        $stmt_votacion->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $id_usuario]);

        // Obtener el ID de la votación recién insertada, necesario para las opciones
        $votacion_id = $pdo->lastInsertId();

        // Insertar cada opción de voto en la tabla `opciones_votacion`
        $stmt_opcion = $pdo->prepare(
            "INSERT INTO opciones_votacion (votacion_id, texto_opcion) 
             VALUES (?, ?)"
        );
        
        foreach ($opciones_unicas as $opcion_texto) {
            // Asegurarse de que la opción no esté vacía después de trim() y unique()
            if (!empty($opcion_texto)) { 
                $stmt_opcion->execute([$votacion_id, $opcion_texto]);
            }
        }

        // Si todas las inserciones fueron exitosas, confirma la transacción
        $pdo->commit();

        // Redirigir al usuario a una página de éxito
        // Ajusta esta ruta si es diferente a la de tu script de reservas
        header("Location: ../../../web/src/votacion/ver_votacion.php?success=votacion_creada");
        exit();

    } catch (PDOException $e) {
        // Si algo falla, revertir la transacción para deshacer los cambios
        $pdo->rollBack();
        // Log el error para depuración (no mostrarlo directamente al usuario en producción)
        error_log("Error al crear la votación: " . $e->getMessage());
        // Redirigir al usuario con un mensaje de error
        header("Location: ../../../web/src/votacion/crear_votacion.php?error=db_error");
        exit();
    }
} else {
    // Si se intenta acceder al script directamente sin enviar el formulario (GET request)
    header("Location: ../../../web/src/votacion/ver_votacion.php");
    exit();
}
?>