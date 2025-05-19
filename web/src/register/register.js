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
        /*
        .then(response => response.text()) // Obtener la respuesta como texto
        */
       .then(response => response.json())
       .then(data => {
            if (data.codigo === "registro_exitoso") {
                messageDiv.textContent = "Registro exitoso.";
                form.reset();
            } else {
                window.top.location.href = './registerError.php?mensaje=' + encodeURIComponent(data.codigo);
            }
        })
        
        .catch(error => {
            console.error('Error:', error);
            messageDiv.textContent = 'Error de comunicación con el servidor.';
        });
    });
});