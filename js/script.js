//create a function that will change the width of the navbar based on the scroll position of the window
function changeNav() {
    var nav = document.getElementById("navbar");
    nav.style.transition = "0.5s";
    if (window.scrollY > 50) {
      nav.style.width = "100%";
    } else {
      nav.style.width = "95%";
    }
  }

//add an event listener to the window that will call the changeNav function when the window is scrolled
window.addEventListener("scroll", changeNav);
