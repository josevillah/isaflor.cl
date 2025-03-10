import { Alert } from './alerts.js';
const inputCategory = document.querySelector('input[name="searchCategory"]');
const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

async function fetchFunction(info, urlQuery) {
    return new Promise(async (resolve, reject) => {
        try {
            const response = await fetch(urlQuery, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `searchCategory=${encodeURIComponent(info)}`
            });

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

async function fetchFunctionPost(formData, urlQuery) {
    try {
        const response = await fetch(urlQuery, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body:JSON.stringify(formData) // Enviar FormData directamente
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

function addItemsToTable(items) {
    const tableCategories = document.querySelector('#categories');
    tableCategories.querySelector('tbody').innerHTML = '';

    items.forEach((item, index) => {
        let tr = document.createElement('tr');
        tr.setAttribute('data-id', item.id);
        tr.innerHTML = `
            <td>${ index + 1 }</td>
            <td>${ item.nombre }</td>
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


if (inputCategory) {
    let timer; // Variable para almacenar el temporizador

    inputCategory.addEventListener('input', (e) => {
        clearTimeout(timer); // Limpiar el temporizador anterior
        timer = setTimeout(async () => {
            const search = e.target.value.toLowerCase().trim();

            if(search.length == 0){
                const response = await fetchFunction(search, `${url}/index.php/ipanel/getAllCategories`);
                if(response.length > 0) {
                    addItemsToTable(response);
                }
            }

            if (search.length > 0) {
                const response = await fetchFunction(search, `${url}/index.php/ipanel/searchCategories`);
                if(response.length > 0) {
                    addItemsToTable(response);
                }
            }
        }, 500);
    });
}

const tableCategories = document.querySelector('#categories');
if(tableCategories){
    tableCategories.addEventListener('click', async (e) => {
        e.preventDefault();
        let target = e.target;

        // Evento click para modificar la categoría
        if(target.closest('a') && target.closest('a').classList.contains('table-edit')){
            target = target.closest('a');
            const data = {
                id: target.closest('tr').getAttribute('data-id'),
                nombre: target.closest('tr').querySelector('td:nth-child(2)').textContent
            }
            window.location.href = `${url}/index.php/ipanel/editCategory/?id=${data.id}&nombre=${data.nombre}`;
        }
        
        // Evento click para eliminar la categoría
        if(target.closest('a') && target.closest('a').classList.contains('table-trash')){
            target = target.closest('a');
            let id = target.closest('tr').getAttribute('data-id');

            const myAlert = new Alert();
            myAlert.show();
            const confirm = document.querySelector('.alert-accept');
            confirm.addEventListener('click', async (e) => {
                e.preventDefault();
                myAlert.close();
                const response = await fetchFunctionPost(id, `${url}/index.php/ipanel/deleteCategory`);
                if(response){
                    myAlert.showNotification('Categoría eliminada', 1);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2200);
                }else{
                    myAlert.showNotification('Ups algo ocurrió, vuelve a intentarlo ', 3);
                }
            });
        }
    });
}


const formNewCategory = document.querySelector('#formNewCategory');

if(formNewCategory){
    formNewCategory.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(
            new FormData(e.target)
        );

        const myAlert = new Alert();
        myAlert.show();
        const confirm = document.querySelector('.alert-accept');

        confirm.addEventListener('click', async (e) => {
            e.preventDefault();
            myAlert.close();
            const response = await fetchFunctionPost(data, `${url}/index.php/ipanel/newCategory`);
            if(response){
                myAlert.showNotification('Nueva categoría registrada', 1);
                setTimeout(() => {
                    window.location.reload();
                }, 2200);
            }else{
                myAlert.showNotification('Ups algo ocurrió, vuelve a intentarlo ', 3);
            }
        });

    });
}

const formEditCategory = document.querySelector('#formEditCategory');

if(formEditCategory){
    formEditCategory.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(
            new FormData(e.target)
        );

        if(data.categoryName.length > 0){
            const myAlert = new Alert();
            myAlert.show();
            const confirm = document.querySelector('.alert-accept');

            confirm.addEventListener('click', async (e) => {
                e.preventDefault();
                myAlert.close();
                const response = await fetchFunctionPost(data, `${url}/index.php/ipanel/updateCategory`);
                if(response){
                    myAlert.showNotification('Categoría actualizada', 1);
                    setTimeout(() => {
                        window.location.href = `${url}/index.php/ipanel/categories`;
                    }, 2200);
                }else{
                    myAlert.showNotification('Ups algo ocurrió, vuelve a intentarlo ', 3);
                }
            });
        }else{
            const myAlert = new Alert();
            myAlert.showNotification('El campo no puede estar vacío', 3);
            return;
        }
    });
}