function hidedisplayMenu(elt) {
    let nav = elt.lastElementChild;
    if(nav.classList.contains("visibleNav")) {
        nav.classList.remove('visibleNav');
        nav.classList.add('hiddenNav');
    }
    else if (nav.classList.contains("hiddenNav")) {
        nav.classList.remove('hiddenNav');
        nav.classList.add('visibleNav');
    }
}


document.addEventListener("click", function(event) {
    var targetElement = event.target;
    var isMenuClicked = targetElement.closest("#nav") !== null;
    var isParentClicked = targetElement.closest("#profilenav") !== null;

    // Si le clic n'est pas sur le menu ou le div parent, cache le menu
    if (!isMenuClicked && !isParentClicked) {
        if(nav.classList.contains("visibleNav")) {
            nav.classList.remove('visibleNav');
            nav.classList.add('hiddenNav');
        }
    }

});