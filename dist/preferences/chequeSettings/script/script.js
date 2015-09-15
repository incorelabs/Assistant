$(document).ready(function () {
    localStorage.setItem("websiteRoot", "../../");

    console.log(window.innerWidth);
    if (window.innerWidth < 500) {
        $(':input').removeAttr('placeholder');
    }
});