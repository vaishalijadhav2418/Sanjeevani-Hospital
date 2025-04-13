document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.slider');
    const dots = document.querySelectorAll('.dot');
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
  
    let currentIndex = 0;
    // To change the images dynamically every 
// 5 Secs, use SetInterval() method
  
    function updateSlider() {
      const translateValue = -currentIndex * 100 + '%';
      slider.style.transform = 'translateX(' + translateValue + ')';
    }
  
    function setActiveDot() {
      dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
      });
    }
  
    function nextSlide() {
      currentIndex = (currentIndex + 1) % dots.length;
      updateSlider();
      setActiveDot();
    }
  
    function prevSlide() {
      currentIndex = (currentIndex - 1 + dots.length) % dots.length;
      updateSlider();
      setActiveDot();
    }
  
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        currentIndex = index;
        updateSlider();
        setActiveDot();
      });
    });
  
    prevButton.addEventListener('click', prevSlide);
    nextButton.addEventListener('click', nextSlide);
    setInterval(nextSlide, 3000);
     
  });
  
