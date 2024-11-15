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

// async function fetchFunctionGet(info, urlQuery) {
//     try {
//         // Construir la URL con los parámetros de consulta
//         const url = new URL(urlQuery);
//         url.searchParams.append('searchCategory', encodeURIComponent(info));

//         const response = await fetch(url, {
//             method: 'GET',
//             headers: {
//                 'Content-Type': 'application/x-www-form-urlencoded'
//             }
//         });

//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }

//         const data = await response.json();
//         return data;

//     } catch (error) {
//         console.error('Error:', error);
//         return false;
//     }
// }

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

// const selectCategory = document.querySelector('.select-box.category');
// if(selectCategory){
//     selectCategory.addEventListener('change', async (e) => {
//         const selectBox = document.querySelector('.select-box.subcategories');
//         if(selectBox != null){
//             selectBox.innerHTML = '';
//         }
//         const id = e.target.value;
//         const subcategories = await fetchFunctionNormal(`${url}/index.php/subcategorias/getSubCategorias/${id}`);
        
//         if(subcategories){
//             let option;
//             selectBox.innerHTML = `
//             <option selected disabled value="0">Seleccionar subcategoria</option>
//             `;
//             subcategories.forEach(subcategory => {
//                 option = document.createElement('option');
//                 option.value = subcategory.id;
//                 option.textContent = subcategory.nombre;
//                 selectBox.appendChild(option);
//             });
//         }
//     });
// }

function getCurrentDate() {
    const today = new Date();

    // Obtener los componentes de la fecha
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Mes de 2 dígitos
    const day = today.getDate().toString().padStart(2, '0'); // Día de 2 dígitos

    // Obtener los componentes de la hora
    const hours = today.getHours().toString().padStart(2, '0'); // Hora de 2 dígitos
    const minutes = today.getMinutes().toString().padStart(2, '0'); // Minutos de 2 dígitos
    const seconds = today.getSeconds().toString().padStart(2, '0'); // Segundos de 2 dígitos

    // Formatear como Y-m-d H:i:s
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

async function fetchAndDownload(url, info) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: info
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // Convertir la respuesta en un Blob, que es adecuado para archivos binarios
        const blob = await response.blob();

        // Crear un enlace temporal para descargar el archivo
        const downloadUrl = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = downloadUrl;

        // Configurar el nombre del archivo descargado (puedes cambiarlo según tus necesidades)
        a.download = `Reporte_Precios ${getCurrentDate()}.xlsx`;
        
        document.body.appendChild(a);
        a.click();

        // Limpiar el enlace temporal
        window.URL.revokeObjectURL(downloadUrl);
        a.remove();

    } catch (error) {
        console.error('Error:', error);
    }
}


const informForDiference = document.querySelector('#informForDiference');
informForDiference.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = new FormData(e.target);

    const myAlert = new Alert();
    myAlert.show();

    const confirm = document.querySelector('.alert-accept');
    
    confirm.addEventListener('click', async e => {
        e.preventDefault();
        myAlert.close();
        myAlert.showNotification('Generando reporte espere un momento!', 1);
        await fetchAndDownload(`${url}/index.php/inform/generateExcelCategory`, data);
    });

});

const updatingData = document.querySelector('#updatingData');
updatingData.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = new FormData(e.target);

    const myAlert = new Alert();
    myAlert.show();

    const confirm = document.querySelector('.alert-accept');
    
    confirm.addEventListener('click', async e => {
        e.preventDefault();
        myAlert.close();
        const response = await fetchSendData(`${url}/index.php/inform/updateProductForExcel`, data);
        if(!response){
            myAlert.showNotification('Algo no esta bien!', 2);
            return;
        }
        myAlert.showNotification('Datos actualizados correctamente', 1);
        setTimeout(() => {
            window.location.reload();
        },3000);
    });
});