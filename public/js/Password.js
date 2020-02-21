"use strict";

class Password {
    constructor() {
        this.color = "";
        this.strength = "";
    }
}

Password.prototype.begin = function() {
    document.getElementById("diffPass").innerHTML = "No password entered in the field";
    document.getElementById("diffPass").style.color = "grey";
    document.getElementById("diffPass").style.backgroundColor = "darkgrey";
};

Password.prototype.switching = function(password) {
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
    let counter = 0;
    for (let i = 0; i < matchedCase.length; i++) {
        if (new RegExp(matchedCase[i]).test(password)) {
            counter++;
        }
    }

    let strength;
    let color;

    // Display it
    switch (counter) {
        case 0:
        case 1:
            strength = "Very Weak";
            color = "darkred";
            break;
        case 2:
            strength = "Weak";
            color = "red";
            break;
        case 3:
            strength = "Medium";
            color = "orange";
            break;
        case 4:
            strength = "Strong";
            color = "green";
            break;
        default:
            strength = "No password";
            break;
    }
    this.diffPass.innerHTML = strength;
    this.diffPass.style.color = color;
};
