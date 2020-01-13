"use strict";

class Password {
    constructor() {
        this.diffPass = document.getElementById("diffPass");

    }
}

Password.prototype.begin = function () {

};

Password.prototype.switching = function (password) {
    // Do not show anything when the length of password is zero.
    if (password.length === 0) {
        document.getElementById("diffPass").innerHTML = "";
        return;
    }

    // Create an array and push all possible values that you want in password
    var matchedCase = [];
    matchedCase.push("[$@$!%*#?&]"); // Special Charector
    matchedCase.push("[A-Z]");      // Uppercase Alpabates
    matchedCase.push("[0-9]");      // Numbers
    matchedCase.push("[a-z]");     // Lowercase Alphabates

    // Check the conditions
    var ctr = 0;
    for (var i = 0; i < matchedCase.length; i++) {
        if (new RegExp(matchedCase[i]).test(password)) {
            ctr++;
        }
    }
    // Display it
    var color = "";
    var strength = "";
    switch (ctr) {
        case 0:
        case 1:
        case 2:
            strength = "Very Weak";
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
    document.getElementById("diffPass").innerHTML = strength;
    document.getElementById("diffPass").style.color = color;

};