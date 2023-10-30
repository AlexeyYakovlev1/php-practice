"use strict";

const name = document.querySelector("input[name='name']");
const email = document.querySelector("input[name='email']");
const password = document.querySelector("input[name='password']");
const button = document.querySelector("#submit");
const form = document.querySelector(".form");
const loader = document.querySelector(".loader");
const alert = document.querySelector(".alert");

form.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.classList.remove("hidden");
	button.setAttribute("disabled", "true");

	const obj = {
		name: name.value,
		email: email.value,
		password: password.value
	};

	fetch("../logics/auth/registration.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify(obj)
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, message } = data;

			let cssCls = "success";

			if (!success) cssCls = "error";

			alert.innerHTML += `<p class="${cssCls}"><strong>${message}</strong></p>`;

			button.removeAttribute("disabled");

			setTimeout(() => { alert.classList.add("hidden"); }, 10000);

			loader.classList.add("hidden");

			if (!success) return;

			window.location.href = "http://sqlwork/src/pages/login-page.php";
		});
});