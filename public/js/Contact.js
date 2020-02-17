"use strict";

class Contact {
  constructor() {

  }
}

Contact.prototype.submit = function() {

var form = document.getElementById('form');

var formStatus = document.createElement('div');
formStatus.setAttribute('class', 'form-status alert');
form.appendChild(formStatus);

form.onsubmit = function (e) {
	e.preventDefault();

	var data = {};
	for (var i = 0, ii = form.length; i < ii; ++i) {
		var input = form[i];
		if (input.name) {
			data[input.name] = input.value;
		}
	}

	var request = new XMLHttpRequest();
	request.open(form.method, form.action, true);
	request.send(JSON.stringify(data));

	request.onloadend = function (response) {
		if (response.target.status === 0) {
			formStatus.className += ' alert-danger';
			formStatus.innerHTML = form.dataset.formError;
		} else if (response.target.status === 400) {
			formStatus.className += ' alert-danger';
			formStatus.innerHTML = JSON.parse(responseText).error;
		} else if (response.target.status === 200) {
			formStatus.className += ' alert-success';
			formStatus.innerHTML = form.dataset.formSuccess;
		}
	};
};
}
