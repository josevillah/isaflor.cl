import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

// Obtener el input de archivo y el label
const fileInput = document.getElementById('idfileExcel');
const fileLabel = document.querySelector('label[for="idfileExcel"]');

// Agregar evento change al input de archivo
fileInput.addEventListener('change', () => {
    // Comprobar si hay un archivo seleccionado
    if (fileInput.files.length > 0) {
        // Obtener el nombre del archivo
        const fileName = fileInput.files[0].name;
        // Cambiar el texto del label por el nombre del archivo
        fileLabel.textContent = fileName;
    } else {
        // Restablecer el texto del label si no hay archivo seleccionado
        fileLabel.textContent = 'Sube archivo excel';
    }
});

const inform = document.querySelector('#informs');

inform.addEventListener('submit', (e) => {
    e.preventDefault();
    window.location.href = `${url}/index.php/inform/generateExcel`;
});

async function fetchFunctionGet(info, urlQuery) {
    try {
        // Construir la URL con los parámetros de consulta
        const url = new URL(urlQuery);
        url.searchParams.append('searchCategory', encodeURIComponent(info));

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Error:', error);
        return false;
    }
}

async function fetchFunctionNormal(urlQuery) {
    try {
        const response = await fetch(urlQuery, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Error:', error);
        return false;
    }
}

async function fetchSendData(url, info) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: info
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        return data;

    } catch (error) {
        console.error('Error:', error);
        return false;
    }
}

const selectCategory = document.querySelector('.select-box.category');
selectCategory.addEventListener('change', async (e) => {
    const selectBox = document.querySelector('.select-box.subcategories');
    selectBox.innerHTML = '';
    const id = e.target.value;
    const subcategories = await fetchFunctionNormal(`${url}/index.php/subcategorias/getSubCategorias/${id}`);
    
    if(subcategories){
        let option;
        selectBox.innerHTML = `
        <option selected disabled value="0">Seleccionar subcategoria</option>
        `;
        subcategories.forEach(subcategory => {
            option = document.createElement('option');
            option.value = subcategory.id;
            option.textContent = subcategory.nombre;
            selectBox.appendChild(option);
        });
    }
});


const informForCategory = document.querySelector('#informForCategory');
informForCategory.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = new FormData(e.target);
    const response = await fetchSendData(`${url}/index.php/inform/generateExcelCategory`, data);
    console.log(response);
});