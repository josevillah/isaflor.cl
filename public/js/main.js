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

const containerImgProduct = document.querySelector('.product-view-img');
const imgProduct = document.querySelector('.product-view-img img');

if (containerImgProduct) {
    containerImgProduct.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = containerImgProduct.getBoundingClientRect();
        const x = ((e.clientX - left) / width) * 100;
        const y = ((e.clientY - top) / height) * 100;

        imgProduct.style.transformOrigin = `${x}% ${y}%`;
        imgProduct.style.transform = 'scale(2)';
    });

    containerImgProduct.addEventListener('mouseleave', () => {
        imgProduct.style.transformOrigin = 'center';
        imgProduct.style.transform = 'scale(1)';
    });
}