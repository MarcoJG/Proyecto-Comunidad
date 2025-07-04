function navToLogin() {
    window.top.location.href = '../login/index.php';
}

document.addEventListener('DOMContentLoaded', function() {
    const welcomeMessage = document.getElementById('welcome-message');
    const userEmail = document.getElementById('user-email');
    const logoutLink = document.getElementById('logout-link');
    const dropdownBtn = document.querySelector('.user-dropdown-btn');
    const dropdownContent = document.querySelector('.user-dropdown-content');
    const loginButtonContainer = document.querySelector('.buttons-container');
    const userInfoContainer = document.querySelector('.user-info-container');

    // Función para obtener la información del usuario
    function getUserInfo() {
        fetch('../../../backend/src/user/get_user_info.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    welcomeMessage.textContent = `Bienvenido, ${data.usuario}`;
                    userEmail.textContent = data.correo;
                    userInfoContainer.style.display = 'flex'; // Mostrar información del usuario
                    loginButtonContainer.style.display = 'none'; // Ocultar botón de inicio de sesión
                } else {
                    userInfoContainer.style.display = 'none'; // Ocultar información del usuario
                    loginButtonContainer.style.display = 'flex'; // Mostrar botón de inicio de sesión
                }
            })
            .catch(error => {
                console.error('Error al obtener la información del usuario:', error);
                welcomeMessage.textContent = 'Error al cargar la información del usuario';
            });
    }

    // Mostrar/ocultar el desplegable
    if (dropdownBtn) {
        dropdownBtn.addEventListener('click', function() {
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
    }

    // Cerrar sesión
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = '../../../backend/src/login/logout.php';
        });
    }

    getUserInfo(); // Obtener la información del usuario al cargar la página
});