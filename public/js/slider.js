const slider = document.querySelector('.slider');
const buttonsSlider = document.querySelector('.slider-buttons');
let position = 0;
let intervalId;
let timeInterval = 4000;

const movingSlider = () => {
    const sliderItems = slider.querySelectorAll('.slider img').length; // count the number of images
    const maxScroll = (sliderItems - 1) * 100; // calculate the maximum scroll

    position -= 100;
    position = position < -maxScroll ? 0 : position; // if we've reached the end, go back to the start

    slider.style.transform = `translateX(${position}%)`;
};

const startSlider = () => {
    // Clear the existing interval
    if (intervalId) {
        clearInterval(intervalId);
    }

    // Start a new interval
    intervalId = setInterval(movingSlider, timeInterval);
};


if(buttonsSlider){
    // Start the slider initially
    startSlider();

    buttonsSlider.addEventListener('click', (e) => {
        const target = e.target.closest('button');
        if(target){
            const sliderItems = slider.querySelectorAll('.slider img').length; // count the number of images
            const maxScroll = (sliderItems - 1) * 100; // calculate the maximum scroll
    
            if(target.classList.contains('button-left')){
                position += 100;
                position = position > 0 ? -maxScroll : position; // use maxScroll instead of a fixed value
            } else if(target.classList.contains('button-right')){
                position -= 100;
                position = position < -maxScroll ? 0 : position; // use maxScroll instead of a fixed value
            }
            slider.style.transform = `translateX(${position}%)`;
    
            // Restart the slider
            startSlider();
        }
    });
    
    window.addEventListener('load', () => {
        const sliderItems = slider.querySelectorAll('.slider img').length; // count the number of images
        if(sliderItems == 1){
            buttonsSlider.style.display = 'none';
        }
    });
}
