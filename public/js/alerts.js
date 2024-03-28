export class Alert{
    constructor(){
        this.alert = '';
        this.container = '';
    }

    show(message, type){
        const body = document.querySelector('.alert-body');
        
        if(type === 1){ // success
            body.innerHTML = `
                <svg class="success" width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                <p>${message}</p>
            `;
        }
        
        if(type === 2){ // success
            body.innerHTML = `
                <svg class="warning" width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svglns=>
                <p>${message}</p>
            `;
        }
        
        if(type === 3){ // success
            body.innerHTML = `
                <svg class="error" width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v4" /><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" /><path d="M12 16h.01" /></svglns=>
                <p>${message}</p>
            `;
        }

        this.alert = document.querySelector('.alert');
        this.container = document.querySelector('.alert-container');

        if(!this.container.classList.contains('show')){
            this.container.classList.add('show')
        }

        if(!this.alert.classList.contains('show')){
            this.alert.classList.add('show')
        }

        document.body.style.overflow = 'hidden';
    }

    close(){
        this.alert = document.querySelector('.alert')
        this.container = document.querySelector('.alert-container')

        if(this.container.classList.contains('show')){
            this.container.classList.remove('show')
        }

        if(this.alert.classList.contains('show')){
            this.alert.classList.remove('show')
        }

        document.body.style.overflow = 'auto'
    }
}