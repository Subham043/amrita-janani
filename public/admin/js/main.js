var fullScreen = document.querySelector('[data-toggle="fullscreen"]')
fullScreen.addEventListener("click", function (e) {
    e.preventDefault();
    document.body.classList.toggle("fullscreen-enable")
    document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)
})

darkMode = document.querySelectorAll(".light-dark-mode")
darkMode[0].addEventListener("click", function (e) {
    document.getElementsByTagName('html')[0].setAttribute("data-layout-mode", document.getElementsByTagName('html')[0].getAttribute("data-layout-mode")=='dark' ? "light" : "dark");
})

var sideBar = document.getElementById('vertical-hover')
sideBar.addEventListener("click", function (e) {
    document.getElementsByTagName('html')[0].setAttribute("data-sidebar-size", document.getElementsByTagName('html')[0].getAttribute("data-sidebar-size")=='sm-hover' ? "sm-hover-active" : "sm-hover");
})