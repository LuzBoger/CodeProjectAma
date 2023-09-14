var elements = document.querySelectorAll('.imageSVG');
var style = window.getComputedStyle(elements[0]);
var compteur = [];
var mouseout = [];

for (var i = 0; i < elements.length; i++) {
  compteur[i] = 1;
  mouseout[i] = false;

  elements[i].addEventListener('mouseover', function(index) {
    return function() {
      this.style.animationIterationCount = compteur[index];
      this.classList.add('elementA');
      console.log('MouseOver');
    };
  }(i));

  elements[i].addEventListener('mouseout', function(index) {
    return function() {
      mouseout[index] = true;
    };
  }(i));

  elements[i].addEventListener('animationend', function(index) {
    return function() {
      if (mouseout[index] == true) {
        this.classList.remove('elementA');
        console.log('AnimationEnd');
        mouseout[index] = false;
        compteur[index] = 1;
      } else {
        compteur[index]++;
        this.style.animationIterationCount = compteur[index];
      }
    };
  }(i));
}

