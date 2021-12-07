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
}; // toggle tabs on codeblock


window.addEventListener("load", function () {
  // get all tab_containers in the document
  var tabContainers = getAll(".tab__container"); // bind click event to each tab container

  for (var i = 0; i < tabContainers.length; i++) {
    get('.tab__menu', tabContainers[i]).addEventListener("click", tabClick);
  } // each click event is scoped to the tab_container


  function tabClick(event) {
    var scope = event.currentTarget.parentNode;
    var clickedTab = event.target;
    var tabs = getAll('.tab', scope);
    var panes = getAll('.tab__pane', scope);
    var activePane = get(".".concat(clickedTab.getAttribute('data-tab')), scope); // remove all active tab classes

    for (var i = 0; i < tabs.length; i++) {
      tabs[i].classList.remove('active');
    } // remove all active pane classes


    for (var i = 0; i < panes.length; i++) {
      panes[i].classList.remove('active');
    } // apply active classes on desired tab and pane


    clickedTab.classList.add('active');
    activePane.classList.add('active');
  }
}); //in page scrolling for documentaiton page

var btns = getAll('.js-btn');
var sections = getAll('.js-section');

function setActiveToIndexBtn(index) {
  for (var i = 0; i < btns.length; i++) {
    btns[i].classList.remove('selected');
  }

  btns[index].classList.add('selected');
}

function smoothScrollTo(element, event) {
  window.scrollTo({
    'behavior': 'smooth',
    'top': element.offsetTop - 20,
    'left': 0
  });
}

if (btns.length && sections.length > 0) {
  btns.forEach(function (btn, index) {
    btn.addEventListener('click', function (event) {
      smoothScrollTo(sections[index], event);
    });
  });
} // fix menu to page-top once user starts scrolling


function fixedPosition() {
  var docNav = get('.doc__nav > ul');
  var sectionTitle = null;
  var sectionTitleScroll = null;
  var findSection = false;
  sections.forEach(function (section, index) {
    sectionTitle = getAll('.section__title', section)[0];
    sectionTitleScroll = sectionTitle.offsetTop - window.scrollY;

    if (sectionTitleScroll > 45 && !findSection) {
      setActiveToIndexBtn(index - 1 > 0 ? index - 1 : 0);
      findSection = true;
    }
  });

  if (!findSection) {
    setActiveToIndexBtn(sections.length - 1);
  }

  if (docNav) {
    if (window.pageYOffset > 63) {
      docNav.classList.add('fixed');
      docNav.classList.add('col-2');
    } else {
      docNav.classList.remove('fixed');
      docNav.classList.remove('col-2');
    }
  }
}

window.addEventListener('scroll', function () {
  fixedPosition();
});
fixedPosition(); // responsive navigation

var topNav = get('.menu');
var icon = get('.toggle');
window.addEventListener('load', function () {
  function showNav() {
    if (topNav.className === 'menu') {
      topNav.className += ' responsive';
      icon.className += ' open';
    } else {
      topNav.className = 'menu';
      icon.classList.remove('open');
    }
  }

  icon.addEventListener('click', showNav);
});
/******/ })()
;