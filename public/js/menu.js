// Manejando la url dependiendo del entorno
const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;
const containerMenuCategories = document.querySelector('.container-menu-categories');
const menuToggle = document.querySelector('.menu-toggle button');
const menuToggleMovil = document.querySelector('.menu-toggle-movil button');
const menuCategories = document.querySelector('.menu-categories');
const buttonCloseCategories = document.querySelector('.container-close-button button');
const containerMenuMovil = document.querySelector('.container-menu-movil');
const menuMovile = document.querySelector('.menu-links-movil');
const buttonCategoriesMovile = document.querySelector('.btn-categories-movile');

// Variables para el manejo de la busqueda
const searchContainer = document.querySelector('.search-container');
let spinner = document.querySelector('.spinner');
const searchResults = document.querySelector('.search-results');


// * Funciones

// Validar caracteres
const verificarCaracteres = (texto) => {
    // Caracteres especiales permitidos
    const caracteresEspeciales = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '=', '[', ']', '{', '}', ';', ':', ',', '.', '/', '?', '<', '>', '|', '`', '~'];

    // Verificar si el texto contiene algún carácter especial
    return !caracteresEspeciales.some(caracter => texto.includes(caracter));
};

// Deshabilitar scroll
function disableScroll() {
    document.body.style.overflow = 'hidden';
}

// Habilitar scroll
function enableScroll() {
    document.body.style.overflow = '';
}

const handlerMenuCategories = () => {
    containerMenuCategories.classList.toggle('show');
    menuCategories.classList.toggle('show');
    if(document.body.style.overflow === 'hidden'){
        enableScroll();
    }else{
        disableScroll();
    }
};

const handlerCloseMenu = () => {
    containerMenuCategories.classList.remove('show');
    menuCategories.classList.remove('show');
    enableScroll();
};

const handlerMenuMovile = () => {
    containerMenuMovil.classList.toggle('show');
    menuMovile.classList.toggle('show');
    disableScroll();
};

const handlerCloseMenuMovile = () => {
    containerMenuMovil.classList.remove('show');
    menuMovile.classList.remove('show');
    enableScroll();
};

function fetchData(url) {
    return new Promise(async (resolve, reject) => {
        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            resolve(data);

        } catch (error) {
            resolve(false);
        }
    });
}

async function getSubCategories(id) {
    try {
        const data = await fetchData(`${url}/index.php/Subcategorias/getSubCategorias/${id}`);
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
}

const handlerSubmenuCategories = async (event) => {
    const target = event.target.closest('li');
    const submenu = target.querySelector('.dropdown-container');
    const id = target.dataset.id;
    const data = await getSubCategories(id);
    
    if (data) {
        console.log(data);
        submenu.innerHTML = '';
        data.forEach(subcategory => {
            submenu.innerHTML += `
                <li>
                    <a class="list-dropdown" href="${url}/index.php/categorias/viewCategoria/${subcategory.id}?page=1">
                        ${subcategory.nombre}
                    </a>
                </li>
            `;
        });
        submenu.classList.toggle('show');
    }
};

// * Event Listeners
if(window.innerWidth < 850){
    menuToggleMovil.addEventListener('click', handlerMenuMovile);

    containerMenuMovil.addEventListener('click', (e) => {
        
        // Cerrar el menu movile si se hace click en la x
        if(e.target.parentNode.closest('button')){
            handlerMenuMovile();
            enableScroll();
        }
        
        // Cerrar el menu si se hace click fuera de el
        if(e.target.classList.contains('container-menu-movil')){
            handlerCloseMenuMovile();
        }

        if(e.target.closest('button')){
            console.log('click en boton');
        }
    });

    buttonCategoriesMovile.addEventListener('click', (e) =>{
        e.preventDefault();
        handlerMenuCategories();
    });
}

if(window.innerWidth > 850){
    menuToggle.addEventListener('click', handlerMenuCategories);
    buttonCloseCategories.addEventListener('click', handlerCloseMenu);
}
containerMenuCategories.addEventListener('click', (e) => {
    // Cerrar el menu si se hace click fuera de el
    if(e.target.classList.contains('container-menu-categories')){
        handlerCloseMenu();
    }
    
    // Cerrar el menu movile si se hace click fuera de el
    if(e.target.parentNode.closest('button')){
        handlerMenuCategories();
    }
    
    // Abrir submenu contenedor de subcategorias
    if(e.target.closest('li')){
        handlerSubmenuCategories(e);
    }

});


// Variables globales para manejar el temporizador y el tiempo de espera
let typingTimer;
const waitInterval = 1000; // Tiempo de espera en milisegundos (1 segundo)

// Agregar evento 'input' al input de búsqueda
document.querySelector('input[name="SearchProduct"]').addEventListener('input', async (e) => {
    e.preventDefault();

    // Limpiar temporizador existente (si existe)
    clearTimeout(typingTimer);

    // Obtener el valor del texto ingresado
    const textoIngresado = e.target.value.trim().toLowerCase();

    // Verificar si el texto ingresado es menor de 3 caracteres
    if (textoIngresado.length < 3) {
        // Realizar acciones para texto corto (menor de 3 caracteres), como limpiar resultados y ocultar contenedor
        searchContainer.classList.remove('show');
        searchResults.innerHTML = '';
        return;
    }

    // Iniciar temporizador para esperar la entrada del usuario
    typingTimer = setTimeout(async () => {
        // Realizar acciones de búsqueda después de esperar el tiempo de espera
        // Verificar caracteres especiales
        if (!verificarCaracteres(textoIngresado)) {
            return;
        }

        // Realizar acciones para mostrar el estado de búsqueda (spinner, etc.)
        if (!searchContainer.classList.contains('show') || !searchContainer.classList.contains('searching')) {
            searchContainer.classList.add('searching');
            spinner.classList.add('show');
        }

        searchContainer.classList.remove('show');
        searchResults.innerHTML = '';

        // Realizar la búsqueda de datos y procesar los resultados
        const data = await fetchData(`${url}/index.php/productos/getProductosNombre/${textoIngresado}`);
        
        setTimeout(() => {
            searchResults.innerHTML = '';
            
            if (!data) {
                // Mostrar mensaje de 'No se encontraron resultados'
                spinner.classList.remove('show');
                searchContainer.classList.remove('searching');
                searchContainer.classList.add('show');
                searchResults.innerHTML = `<p> No se encontraron resultados </p>`;
                searchResults.classList.add('show');
            } else {
                // Mostrar resultados de la búsqueda
                spinner.classList.remove('show');
                searchContainer.classList.remove('searching');
                searchContainer.classList.add('show');
                data.forEach(product => {
                    searchResults.innerHTML += `
                        <a href="${url}/index.php/productos/viewProduct/${product.id}" class="btn-search-product"> 
                            <img src="${url}/${product.urlimagen}" alt="${product.nompro}">
                            <div class="search-info-product">
                                <p>${product.nompro}</p>
                            </div>
                        </a>
                    `;
                });
                searchResults.classList.add('show');
            }
        }, 2000);
    }, waitInterval);
});


// * Evento para cerrar el contenedor de búsqueda
document.addEventListener('click', (e) => {
    if (!e.target.classList.contains('search-container')) {
        searchContainer.classList.remove('show');
    }
});

document.addEventListener('click', (e) => {
    if (e.target.closest('input')) {
        if(searchResults.innerHTML !== '')
            searchContainer.classList.add('show');
    }
});