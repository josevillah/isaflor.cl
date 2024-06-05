import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

async function fetchFunctionPost(formData, urlQuery) {
    try {
        const response = await fetch(urlQuery, {
            method: 'POST',
            body: formData // Enviar FormData directamente
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

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

function addItemsToTable(items) {
    const tableCategories = document.querySelector('#productsTable');
    tableCategories.querySelector('tbody').innerHTML = '';
    items.forEach((item, index) => {
        let tr = document.createElement('tr');
        tr.setAttribute('data-id', item.id);
        tr.innerHTML = `
            <td>${ item.codpro.length > 0 ?  item.codpro : 'Sin datos'}</td>
            <td>${ item.nompro }</td>
            <td class="imgTable">
                <img src="${url}/${item.urlimagen}?v=${Math.random()}">
            </td>
            <td class="table-options">
                <a class="table-edit" href="#">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                </a>
                <a class="table-trash" href="#">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                </a>
            </td>
        `;
        tableCategories.querySelector('tbody').appendChild(tr);
    });
}

function addDataToProduct(product){
    const inputCodpro = document.querySelector('#productCode');
    const inputName = document.querySelector('#productName');
    const inputPrice = document.querySelector('#productPrice');
    const inputOfertPrice = document.querySelector('#productOfertPrice');
    const productImg = document.querySelector('img.file');
    const inputTag = document.querySelector('#productTag');
    const inputAncho = document.querySelector('#productAncho');
    const inputLargo = document.querySelector('#productLargo');
    const inputDescription = document.querySelector('#productDetails');
    const inputRend = document.querySelector('#productRend');
    const btnSwitch = document.querySelector('#btn-switch');
    const btnSubmit = document.querySelector('input[type="submit"]');

    inputCodpro.value = product.codpro;
    inputName.value = product.nompro;
    inputPrice.value = product.prepro;
    productImg.src = `${url}/${product.urlimagen}?v=${Math.random()}`;
    inputOfertPrice.value = product.preoferpro;
    inputTag.value = product.marcapro;
    inputAncho.value = product.anchpro;
    inputLargo.value = product.largpro;
    inputDescription.value = product.despro;
    if(product.medida.length > 0){
        let target = inputRend.closest('.form-control');
        target.classList.remove('hidden');
        inputRend.value = product.medida;
    }

    if(product.cantidad == false){
        btnSwitch.checked = false;
    }
    
    if(product.cantidad == true){
        btnSwitch.checked = true;
    }

    btnSubmit.value = 'Editar Producto';
}

const searchProduct = document.querySelector('#searchProduct');
let timer;
// Escuchar el evento input para buscar productos
searchProduct.addEventListener('input', async e => {
    clearTimeout(timer); // Limpiar el temporizador anterior
    timer = setTimeout(async () => {
        const search = e.target.value.toLowerCase().trim();
        if(search.length > 0){
            const response = await fetchFunctionGet(search, `${url}/index.php/productos/searchProduct`);
            if(response.length > 0) {
                addItemsToTable(response);
            }
        }
    },500);
})

const tableContainer = document.querySelector('.table-container');
const productsTable = document.querySelector('#productsTable');
const formContainer = document.querySelector('.form-container');
const containerButtons = document.querySelector('.container-btnBack');
const searchBar = document.querySelector('#searchBar');


function addDataSelectCategories(product, categories){
    const selectBox = document.querySelector('.select-box.category');
    addDataToProduct(product);
    selectBox.innerHTML = `
        <option selected value="${product.id_categoria}">${product.nombre_categoria}</option>
    `;
    let option;
    categories.forEach(category => {
        if(category.id !== product.id_categoria){
            option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.nombre;
            selectBox.appendChild(option);
        }
    });
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

function selectSubcategoriesEmpty(product, categories){
    const selectBox = document.querySelector('.select-box.subcategories');
    selectBox.innerHTML = `
        <option selected disabled value="0">Seleccione</option>
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

if(productsTable){
    productsTable.addEventListener('click', async (e) => {
        e.preventDefault();
        let target = e.target;
        // Evento click para modificar la categoría
        if(target.closest('a') && target.closest('a').classList.contains('table-edit')){
            target = target.closest('a');
            let id = target.closest('tr').getAttribute('data-id');
            const idProduct = document.querySelector('#idProduct');
            idProduct.value = id;
            const product = await fetchFunctionGet(id, `${url}/index.php/productos/getProductForEdit`);
            const categories = await fetchFunctionNormal(`${url}/index.php/categorias/getCategorias`);
            const subcategories = await fetchFunctionNormal(`${url}/index.php/subcategorias/getSubCategorias/${product.id_categoria}`);
            tableContainer.classList.add('hidden');
            formContainer.classList.contains('hidden') ? formContainer.classList.remove('hidden') : formContainer.classList.add('hidden');
            const divider = document.querySelector('.divider');
            searchBar.classList.contains('hidden') ? searchBar.classList.remove('hidden') : searchBar.classList.add('hidden');
            divider.classList.contains('hidden') ? divider.classList.remove('hidden') : divider.classList.add('hidden');
            containerButtons.classList.contains('hidden') ? containerButtons.classList.remove('hidden') : containerButtons.classList.add('hidden');
            addDataSelectCategories(product, categories);
            addDataSelectSubcategories(product, subcategories);
        }
    });

    const selectCategories = document.querySelector('.select-box.category');
    selectCategories.addEventListener('change', async e => {
        let target = e.target.value;
        const idProduct = document.querySelector('#idProduct');
        const subcategories = await fetchFunctionNormal(`${url}/index.php/subcategorias/getSubCategorias/${target}`);
        const product = await fetchFunctionGet(idProduct.value, `${url}/index.php/productos/getProductForEdit`);
        selectSubcategoriesEmpty(product, subcategories);
    });

    containerButtons.addEventListener('click', e => {
        let target = e.target;

        // click en el boton de volver
        if(target.closest('button') && target.closest('button').classList.contains('back')){
            e.preventDefault();
            formContainer.classList.add('hidden');
            tableContainer.classList.contains('hidden') ? tableContainer.classList.remove('hidden') : tableContainer.classList.add('hidden');
            searchBar.classList.contains('hidden') ? searchBar.classList.remove('hidden') : searchBar.classList.add('hidden');
            containerButtons.classList.contains('hidden') ? containerButtons.classList.remove('hidden') : containerButtons.classList.add('hidden');
        }

        // click en el boton de ocultar
        if(target.classList.contains('label-switch')){
            const divInput = document.querySelector('.btn-check');
            const inputId = divInput.querySelector('input[type="checkbox"]');
            let data = {};

            // Activar stock
            if(inputId.checked == false){
                data = {
                    id: document.querySelector('#idProduct').value,
                    stock: 1
                }
            }
            
            // Desactivar stock
            if(inputId.checked == true){
                data = {
                    id: document.querySelector('#idProduct').value,
                    stock: 0
                }
            }

            const formData = new FormData();
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    formData.append(key, data[key]);
                }
            }

            try {
                fetchFunctionPost(formData ,`${url}/index.php/productos/editStock`);
            }catch(error){
                console.error('Error:', error);
            }
        }

        // click en el boton de eliminar
        if(target.closest('button') && target.closest('button').classList.contains('btn-delete')){
            e.preventDefault();
            alert('Eliminar, se encuentra en desarrollo');
        }
    });
}

async function selectCategories(){
    try{
        const categories = await fetchFunctionNormal(`${url}/index.php/categorias/getCategorias`);
        const selectBox = document.querySelector('.select-box.category');
        selectBox.innerHTML = `
            <option selected value="0" disabled>Seleccione una categoría</option>
        `;
        let option;
        categories.forEach(category => {
            option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.nombre;
            selectBox.appendChild(option);
        });
    }catch(error){
        console.error('Error:', error);
    }
    
}

function resetDataProduct(){
    const inputCodpro = document.querySelector('#productCode');
    const inputName = document.querySelector('#productName');
    const inputPrice = document.querySelector('#productPrice');
    const inputOfertPrice = document.querySelector('#productOfertPrice');
    const productImg = document.querySelector('img.file');
    const inputTag = document.querySelector('#productTag');
    const inputAncho = document.querySelector('#productAncho');
    const inputLargo = document.querySelector('#productLargo');
    const inputDescription = document.querySelector('#productDetails');
    const inputRend = document.querySelector('#productRend');
    const btnSwitch = document.querySelector('#btn-switch');
    const btnSubmit = document.querySelector('input[type="submit"]');

    inputCodpro.value = '';
    inputName.value = '';
    inputPrice.value = '';
    productImg.src = '';
    inputOfertPrice.value = '';
    inputTag.value = '';
    inputAncho.value = '';
    inputLargo.value = '';
    inputDescription.value = '';
    inputRend.value = '';
    btnSwitch.checked = false;
    btnSubmit.value = 'Nuevo Producto';
}

searchBar.addEventListener('click', e => {
    e.preventDefault();
    let target = e.target;
    if(target.closest('button') && target.closest('button').classList.contains('btn-new-product')){
        resetDataProduct();
        selectCategories();
        const divider = document.querySelector('.divider');
        const btnCheck = document.querySelector('.btn-check input');
        const productRend = document.querySelector('#productRend');
        btnCheck.checked = true;
        productRend.closest('.form-control').classList.contains('hidden') ? productRend.closest('.form-control').classList.remove('hidden') : productRend.closest('.form-control').classList.add('hidden');
        tableContainer.classList.add('hidden');
        divider.classList.add('hidden');
        searchBar.classList.add('hidden');
        containerButtons.classList.contains('hidden') ? containerButtons.classList.remove('hidden') : containerButtons.classList.add('hidden');
        formContainer.classList.contains('hidden') ? formContainer.classList.remove('hidden') : formContainer.classList.add('hidden');
    }
});


document.querySelector('form').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const result = await fetchFunctionPost(formData, `${url}/index.php/productos/newOrEditProduct`);
        if(result){
            const myAlert = new Alert();
            myAlert.show();
        
            const confirm = document.querySelector('.alert-accept');
            
            confirm.addEventListener('click', async e => {
                e.preventDefault();
                myAlert.close();
                myAlert.showNotification('Cambios realizados con éxito!', 1);
                setTimeout(() => {
                    window.location.reload();
                }, 2200);
            });
        }
    } catch (error) {
        console.error('Error al enviar el formulario:', error);
    }
});