window.onload = function () {
  var imageContainer = document.getElementById('revolving-image');
  var burgerTitleArea = document.getElementById('burger-name');
  var burgerDescriptionArea = document.getElementById('burger-description');
  var timer;
  var imageSources = ['images/about_us/burger-868145_640.jpg', 'images/about_us/burger-2707320_640.jpg', 'images/about_us/burger-2762371_1920.jpg'];
  var burgerTitles = ['The Meat Lover', 'The Hipster', 'The Classic'];
  var burgerDescriptions = ['Juicy beef patty topped with bacon, pulled pork, sundried tomatoe, an onion ring and barbeque mayo.', 'A cheesed-stuffed portobello mushroom "patty", topped with arugala, tomatoes, avocado, mozzarella cheese and mayo.', 'Classic beef patty topped with lettuce, tomatoe, onions, American cheese, and our inhouse Burger Port sauce.'];
  var counter = 0;

  var leftBtn = document.getElementsByClassName('arrow-container')[0];
  var rightBtn = document.getElementsByClassName('arrow-container')[1];

  imageContainer.onmouseover = function () {
    clearInterval(timer);
  }

  imageContainer.onmouseout = function () {
    startTimer();
  }

  startTimer();

  function startTimer() {
    timer = setInterval(revolveImage, 5000);
  }

  function revolveImage() {
    counterManager(1);
    imageContainer.src = imageSources[counter];
    burgerTitleArea.innerHTML = burgerTitles[counter];
    burgerDescriptionArea.innerHTML = burgerDescriptions[counter];
  }

  function counterManager(id) {
    if (id === 1) {
      if (counter === 2) {
        counter = 0;
      } else {
        counter++;
      }
    } else if (id === 2) {
      if (counter === 0) {
        counter = 2;
      } else {
        counter--;
      }
    }
  }

  leftBtn.onclick = function() {
    clearInterval(timer);
    counterManager(2);
    imageContainer.src = imageSources[counter];
    burgerTitleArea.innerHTML = burgerTitles[counter];
    burgerDescriptionArea.innerHTML = burgerDescriptions[counter];
    setTimeout(startTimer, 3000);
  }

  rightBtn.onclick = function() {
    clearInterval(timer);
    counterManager(1);
    imageContainer.src = imageSources[counter];
    burgerTitleArea.innerHTML = burgerTitles[counter];
    burgerDescriptionArea.innerHTML = burgerDescriptions[counter];
    setTimeout(startTimer, 3000);
  }
}
