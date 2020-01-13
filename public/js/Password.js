"use strict";

class Password {
    constructor() {
        this.color = "";
        this.strength = "";
        // Password.prototype.switching(this.value);
        document.getElementById('passSignUp').addEventListener('keyup', this.switching.bind(this));

    }
}

Password.prototype.begin = function (password) {

};

Password.prototype.switching = function (password) {
    this.diffPass = document.getElementById("diffPass");

    // Do not show anything when the length of password is zero.
    if (password.length === 0) {
        this.diffPass.innerHTML = "";
        return;
    }

    let matchedCase = [];
    matchedCase.push("[$@$!%*#?&]");
    matchedCase.push("[A-Z]");
    matchedCase.push("[0-9]");
    matchedCase.push("[a-z]");

    // Check the conditions
    let ctr = 0;
    for (let i = 0; i < matchedCase.length; i++) {
        if (new RegExp(matchedCase[i]).test(password)) {
            ctr++;
        }
    }

    // Display it
    switch (ctr) {
        case 0:
        case 1:
        case 2:
            this.strength = "Very Weak";
            this.color = "red";
            break;
        case 3:
            this.strength = "Medium";
            this.color = "orange";
            break;
        case 4:
            this.strength = "Strong";
            this.color = "green";
            break;
        default:
            this.strength = "No password";
            break;
    }
    this.diffPass.innerHTML = this.strength;
    this.diffPass.style.color = this.color;

};