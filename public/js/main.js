const buttonUp = document.querySelector('.buttonUp');
const containerButtonUp = document.querySelector('.container-buttonUp');

buttonUp.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Desplazamiento suave
    });
});

window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        containerButtonUp.classList.add('show');
    } else {
        containerButtonUp.classList.remove('show'); // Asegúrate de que el botón se oculte cuando no esté en la parte superior
    }
});