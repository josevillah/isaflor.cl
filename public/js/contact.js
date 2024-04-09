import { Alert } from './alerts.js';

const contact = document.querySelector('form[name="contact"]');

async function sendEmail(data) {
    try {
        const params = new URLSearchParams();
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                params.append(key, data[key]);
            }
        }
        const response = await fetch(`${url}/index.php/Contact/sendEmail?${params}`);
        return response;
    } catch (error) {
        console.error('Error:', error);
    }
}


if(contact){
    contact.addEventListener('submit', async e => {
        e.preventDefault();
        const data = Object.fromEntries(
            new FormData(e.target)
        );

        const response = await sendEmail(data);
        if(response){
            const myAlert = new Alert();
            myAlert.show('Correo enviado exitosamente.', 1);
        }
    });

}