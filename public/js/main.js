const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;
const buttonUp = document.querySelector('.buttonUp');
const containerButtonUp = document.querySelector('.container-buttonUp');
if(buttonUp){
    buttonUp.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Desplazamiento suave
        });
    });
}

window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        containerButtonUp.classList.add('show');
    } else {
        containerButtonUp.classList.remove('show'); // Asegúrate de que el botón se oculte cuando no esté en la parte superior
    }
});


const validCharacters = (cadena) => {
    // Expresión regular que coincide con letras, números y espacios
    var regex = /^[a-zA-Z0-9\s]+$/;
    return regex.test(cadena);
}