const calendar = document.querySelector('.container-calendar'),
    date = document.querySelector('.date'),
    daysContainer = document.querySelector('.days'),
    prev = document.querySelector('.prev'),
    next = document.querySelector('.next');

let today = new Date(),
activeDay,
month = today.getMonth(),
year = today.getFullYear();

const months = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];


// function to add days

function initCalendar(){
    const firstDay = new Date(year, month, 1),
    lastDay = new Date(year, month + 1, 0),
    prevLastDay = new Date(year, month, 0),
    prevDays = prevLastDay.getDay(),
    lastDate = lastDay.getDate(),
    day = firstDay.getDay(),
    nextDays = 7 - lastDay.getDay();

    date.innerHTML = `${months[month]} ${year}`;

    let days;

    days = '';

    // Add previous month's days
    for (let i = prevDays; i > 0; i--) {
        days += `<div class="day prev-date">${prevLastDay.getDate() - i + 1}</div>`;
    }

    // Add current month's days
    for (let i = 1; i <= lastDate; i++) {
        if (
            i === today.getDate() &&
            month === today.getMonth() &&
            year === today.getFullYear()
        ) {
            days += `<div data-id="${i}${month}${year}" class="day active">
            ${i}
            </div>`;
        } else {
            days += `<div data-id="${i}${month}${year}" class="day">
            ${i}
            </div>`;
        }
    }

    // Add next month's days
    for (let i = 1; i <= nextDays; i++) {
        days += `<div class="day next-date">${i}</div>`;
    }

    daysContainer.innerHTML = days;
}


if(date){
    initCalendar();
}

function prevMonth() {
    month--;
    if (month < 0) {
        month = 11;
        year--;
    }
    initCalendar();
}

function nextMonth() {
    month++;
    if (month > 11) {
        month = 0;
        year++;
    }
    initCalendar();
}
if(prev){
    prev.addEventListener('click', prevMonth);
    next.addEventListener('click', nextMonth);
    
    daysContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('day')) {
            console.log(e.target);
        }
    });
}
