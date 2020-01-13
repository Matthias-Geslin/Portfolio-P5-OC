"use strict";

class Slider {
    constructor(containerID) {
        this.container = document.getElementById(containerID) || document.body;
        this.slides = this.container.querySelectorAll(".picture");
        this.total = this.slides.length - 1;
        this.current = 0;

        this.playInSlide = document.getElementById("play");
        this.pauseInSlide = document.getElementById("pause");

        // start on slide 1

        document.getElementById("prev-lb").addEventListener("click", this.prev.bind(this));
        document.getElementById("next-lb").addEventListener("click", this.next.bind(this));
        document.getElementById("play").addEventListener("click", this.play.bind(this));
        document.getElementById("pause").addEventListener("click", this.stop.bind(this));
        document.addEventListener("keydown", this.keyControl.bind(this));
    }
}

Slider.prototype.begin = function () {
    this.slide(this.current);
    this.play();
};

// Keyboard control
Slider.prototype.keyControl = function(event) {
    switch (event.code) {
        case "ArrowLeft":
            this.prev();
            break;
        case "ArrowRight":
            this.next();
            break;
        case "Space":
            this.play();
            break;
        case "Enter":
            this.stop();
            break;
        default:
            return;
    }
    event.preventDefault();
};


// Previous
Slider.prototype.prev = function (interval) {
    this.stop();
    this.slide(this.current);
    if(typeof interval === "number" && (interval % 1) === 0) {
        var context = this;
        this.run = setTimeout(function() {
            context.prev(interval);
        }, interval);
    }

    if (this.current === 0) {
        this.current = this.total;
    }else {
        this.current --;
    }
};


// Next
Slider.prototype.next = function (interval) {
    this.stop();
    this.slide(this.current);
    if(typeof interval === "number" && (interval % 1) === 0) {
        var context = this;
        this.run = setTimeout(function() {
            context.next(interval);
        }, interval);
        this.pauseInSlide.classList.remove("hide");
        this.playInSlide.classList.add("hide");
    }

    if (this.current === this.total) {
        this.current = 0;
    }else {
        this.current ++;
    }
};


// Play
Slider.prototype.play = function () {
    this.next(5000);
};


// Stop Playing
Slider.prototype.stop = function () {
    clearTimeout(this.run);
    this.pauseInSlide.classList.add("hide");
    this.playInSlide.classList.remove("hide");
};


// Manual slide selection
Slider.prototype.slide = function (index) {
    if (index <= 0 && index >= this.total) {
        alert("None displayed.");
    } else {
        this.stop();
        for (let s = 0; s <= this.total; s++) {
            if (s === index) {
                this.slides[s].style.display = "block";
            } else {
                this.slides[s].style.display = "none";
            }
        }
    }
};