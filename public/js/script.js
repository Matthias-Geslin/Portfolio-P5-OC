"use strict";

document.addEventListener("DOMContentLoaded", function (e) {
    if (typeof Slider != "undefined") {
        var slider = new Slider();
        slider.begin();
    }

    if (typeof Password != "undefined") {
        var password = new Password();
        password.begin();
    }

    if (typeof Rpg != "undefined") {
        var rpg = new Rpg();
        rpg.begin();
    }
});
