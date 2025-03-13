import { Alert } from './alerts.js';
const inputAudit = document.querySelector('input[name="searchAudit"]');
const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

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
    const tableAudit = document.querySelector('#tableAudit');
    tableAudit.querySelector('tbody').innerHTML = '';

    items.forEach((item, index) => {
        let tr = document.createElement('tr');
        tr.setAttribute('data-id', item.id);
        tr.innerHTML = `
            <td>${ index + 1 }</td>
            <td>${ item.usuario }</td>
            <td>${ item.tabla }</td>
            <td>${ item.operacion }</td>
            <td>${ item.fecha }</td>
            <td class="table-options">
                <a class="table-edit" href="#">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M11 14h1v4h1" /><path d="M12 11h.01" /></svg>
                </a>
            </td>
            
        `;
        tableAudit.querySelector('tbody').appendChild(tr);
    });
}

if (inputAudit) {

    inputAudit.addEventListener('keydown', async (e) => {
        if (e.key === "Enter") {
            e.preventDefault(); // Evita que se envíe el formulario (si está dentro de uno)
            
            const search = e.target.value.toLowerCase().trim();
    
            if(search.length == 0){
                const response = await fetchFunctionPost(search, `${url}/index.php/audit/getAllAudits`);
                if(response.length > 0) {
                    addItemsToTable(response);
                }
            }
    
            if (search.length > 0) {
                const data = {
                    searchAudit: search,
                    startDate: document.querySelector('input[name="startDate"]').value,
                    endDate: document.querySelector('input[name="endDate"]').value,
                }
                const response = await fetchFunctionPost(data, `${url}/index.php/audit/searchAudit`);
                if(response.length > 0) {
                    addItemsToTable(response);
                }
            }
        }
    });
}

