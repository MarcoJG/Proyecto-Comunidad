<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
</head>
<body>
    <h1>Gestión de Reservas</h1>

    <!-- Filtro de usuario -->
    <form id="filtro-form">
        <label for="usuario_id">Filtrar por Usuario:</label>
        <select name="usuario_id" id="usuario_id">
            <option value="">--Todos los usuarios--</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <!-- Tabla de Reservas -->
    <h2>Reservas</h2>
    <table id="tabla-reservas" border="1">
        <thead>
            <tr>
                <th>ID Reserva</th>
                <th>Usuario</th>
                <th>Fecha Reserva</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se llenarán las filas con JavaScript -->
        </tbody>
    </table>

    <script>
        // Función para cargar las reservas
        async function cargarReservas(usuarioId = '') {
            const url = `../backend/admin_reservas.php?usuario_id=${usuarioId}`;
            const response = await fetch(url);
            const reservas = await response.json();
            
            // Limpiar la tabla
            const tabla = document.getElementById('tabla-reservas').getElementsByTagName('tbody')[0];
            tabla.innerHTML = '';
            
            // Rellenar la tabla con reservas
            reservas.forEach(reserva => {
                const row = tabla.insertRow();
                row.insertCell(0).textContent = reserva.id_reserva;
                row.insertCell(1).textContent = reserva.usuario;
                row.insertCell(2).textContent = reserva.fecha_reserva;
                row.insertCell(3).textContent = reserva.detalles;
            });
        }

        // Cargar usuarios para el filtro
        async function cargarUsuarios() {
            const response = await fetch('../backend/api_usuarios.php'); 
            const usuarios = await response.json();
            const select = document.getElementById('usuario_id');
            usuarios.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id;
                option.textContent = usuario.nombre;
                select.appendChild(option);
            });
        }

        cargarUsuarios();

        // Manejar filtro
        document.getElementById('filtro-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const usuarioId = document.getElementById('usuario_id').value;
            cargarReservas(usuarioId);
        });

        // Cargar las reservas al inicio
        cargarReservas();
    </script>
</body>
</html>
