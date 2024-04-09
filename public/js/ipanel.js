import { Alert } from './alerts.js';

const url = window.location.origin === 'http://localhost' ? `${window.location.origin}/isaflor.cl` : window.location.origin;
const logOut = document.querySelector('.log-out');

if(logOut){
    logOut.addEventListener('click', async e => {
        e.preventDefault();
        const myAlert = new Alert();
        myAlert.show();
        
        const confirm = document.querySelector('.alert-accept');
        
        confirm.addEventListener('click', async e => {
            e.preventDefault();
            myAlert.close();
            window.location.href = `${url}/index.php/ipanel/logout`;
        });
    });
}