document.getElementById('formularioContacto').addEventListener('submit', function(event) {
    event.preventDefault();

    // Validar campos del formulario
    const nombre = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const mensaje = document.getElementById('message').value;
    const erroresValidacion = [];

    // Validar nombre
    if (!nombre) {
        erroresValidacion.push('Por favor, introduzca su nombre.');
    }

    // Validar correo electrónico
    if (!email) {
        erroresValidacion.push('Por favor, introduzca su correo electrónico.');
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        erroresValidacion.push('Por favor, introduzca un correo electrónico válido.');
    }

    // Validar mensaje
    if (!mensaje) {
        erroresValidacion.push('Por favor, introduzca su mensaje.');
    }

    // Mostrar mensajes de error
    if (erroresValidacion.length > 0) {
        document.getElementById('erroresValidacion').textContent = erroresValidacion.join('\n');
        return;
    }

    // Limpiar mensajes de error
    document.getElementById('erroresValidacion').textContent = '';

    const formData = new FormData(this);

    fetch('../../../backend/src/contacto/enviar_correo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const mensajeResultado = document.getElementById('mensajeResultado');
        mensajeResultado.style.opacity = 1;
        mensajeResultado.textContent = data.message;
        mensajeResultado.className = 'mensaje-enviado';

         if (data.success) {
             this.reset();
             setTimeout(() => {
                 mensajeResultado.style.opacity = 0;
             }, 3000);
         }
    });
});