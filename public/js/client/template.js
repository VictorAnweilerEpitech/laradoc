/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/assets/js/client/template.js ***!
  \************************************************/
// utilities
var get = function get(selector, scope) {
  scope = scope ? scope : document;
  return scope.querySelector(selector);
};

var getAll = function getAll(selector, scope) {
  scope = scope ? scope : document;
  return scope.querySelectorAll(selector);
}; //in page scrolling for documentaiton page


var btns = getAll('.js-btn');
var sections = getAll('.js-section'); // Add selected on btn clss

function setActiveToIndexBtn(index) {
  for (var i = 0; i < btns.length; i++) {
    btns[i].classList.remove('selected');
  }

  btns[index].classList.add('selected');
}

function smoothScrollTo(element, event) {
  window.scrollTo({
    'behavior': 'smooth',
    'top': element.offsetTop + 50,
    'left': 0
  });
} // Scroll to specific section


if (btns.length && sections.length > 0) {
  btns.forEach(function (btn, index) {
    btn.addEventListener('click', function (event) {
      smoothScrollTo(sections[index], event);
    });
  });
} // ScrollSpy section


var positionRect = null;
var indexSectionFound = 1;

function activeItem() {
  indexSectionFound = 1;
  sections.forEach(function (section, index) {
    positionRect = section.getBoundingClientRect();

    if (positionRect.top < 50) {
      indexSectionFound = index;
    }
  });
  setActiveToIndexBtn(indexSectionFound);
}

window.addEventListener('scroll', function (event) {
  activeItem();
  displayBtnScrollTop();
});
activeItem(); // ScrollTop Btn

var elBtnScrollTop = get('.btn-scrolltop');

function displayBtnScrollTop() {
  if (window.scrollY > 450) {
    elBtnScrollTop.classList.remove('d-none');
  } else {
    elBtnScrollTop.classList.add('d-none');
  }
}

displayBtnScrollTop();
elBtnScrollTop.addEventListener('click', function (event) {
  window.scrollTo({
    'behavior': 'smooth',
    'top': 0,
    'left': 0
  });
});
/******/ })()
;