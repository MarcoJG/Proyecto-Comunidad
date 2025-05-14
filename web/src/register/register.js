document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registration-form');
    const messageDiv = document.getElementById('registration-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar el envío normal del formulario

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Obtener la respuesta como texto
        .then(data => {
            messageDiv.textContent = data; // Mostrar el mensaje en el div

            if (data.includes("exitoso")) {
                // Registro exitoso, puedes limpiar el formulario o redirigir
                form.reset(); // Limpiar el formulario
                // Opcional: window.location.href = 'pagina_de_exito.php'; // Redirigir a otra página
            } else {
                // Hubo un error, el mensaje ya se muestra
                window.top.location.href = './registerError.php?mensaje=Ha ocurrido un error inesperado';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.textContent = 'Error de comunicación con el servidor.';
        });
    });
});