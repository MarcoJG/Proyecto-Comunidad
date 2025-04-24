function navToLogin () {
document.getElementById('boton-login').addEventListener('click', function() {
    window.top.location.href = '../login/index.php';
});
}
