import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;
const form = document.querySelector('form');

async function changeDataForUser(data) {
    try {
        const params = new URLSearchParams();
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                params.append(key, data[key]);
            }
        }
        const response = await fetch(`${url}/index.php/Ipanel/changeDataForUser?${params}`);
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}

if(form){
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = Object.fromEntries(
            new FormData(e.target)
        );
        
        const myAlert = new Alert();
        myAlert.show();
        
        const confirm = document.querySelector('.alert-accept');
        
        confirm.addEventListener('click', async e => {
            e.preventDefault();
            myAlert.close();
    
            if(data.nombre.trim().length > 0 && data.apellido.trim().length > 0){
                const response = await changeDataForUser(data);
                
                if(response == false){
                    myAlert.showNotification('Las contraseñas no coinciden', 2);
                }
        
                if(response == true){
                    myAlert.showNotification('Datos actualizados correctamente', 1);
                    setTimeout(() => {
                        window.location.href = `${url}/index.php/ipanel/account`;
                    }, 2200);
                }
            }else{
                const myAlert = new Alert();
                myAlert.showNotification('Debe completar todos los campos', 2);
            }
        });
    });
}