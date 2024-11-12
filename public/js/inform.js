import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

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

function addDataSelectSubcategories(product, categories){
    const selectBox = document.querySelector('.select-box.subcategories');
    selectBox.innerHTML = `
    <option selected value="${product.id_subcategoria}">${product.nombre_subcategoria}</option>
    `;
    let option;
    categories.forEach(category => {
        if(category.id !== product.id_subcategoria){
            option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.nombre;
            selectBox.appendChild(option);
        }
    });
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
