import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;

async function login(data) {
    try {
        const params = new URLSearchParams();
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                params.append(key, data[key]);
            }
        }
        const response = await fetch(`${url}/index.php/Ipanel/login?${params}`);
        return response.json();
    } catch (error) {
        console.error('Error:', error);
    }
}


document.querySelector('form')
    .addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(
            new FormData(e.target)
        );

        const myAlert = new Alert();
        if(data.username.length > 4 && data.password.length > 8){
            if(validCharacters(data.username) && validCharacters(data.password)){
                const response = await login(data);

                if(response === false){
                    myAlert.showNotification('Usuario o contraseña incorrecto', 2);
                    return;
                }

                myAlert.showNotification('Inicio de sesión exitoso', 1);
                setTimeout(() => {
                    window.location.href = `${url}/index.php/Ipanel/dashboard`;
                }, 2200);
            }else{
                myAlert.showNotification('Error, caracteres no válidos', 3);
            }
        }else{
            myAlert.showNotification('Error, longitud no válida', 3);
        }
    });