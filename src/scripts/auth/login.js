"use strict";

const email = document.querySelector("input[name='email']");
const password = document.querySelector("input[name='password']");
const form = document.querySelector(".form");
const alert = document.querySelector(".alert");
const button = document.querySelector("#submit");
const loader = document.querySelector(".loader");

form.addEventListener("submit", (event) => {
	event.preventDefault();

	button.setAttribute("disabled", "true");

	const obj = {
		email: email.value,
		password: password.value
	};

	fetch("../logics/auth/login.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify(obj)
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, message, token } = data;

			let cssCls = "success";

			if (!success) cssCls = "error";

			alert.innerHTML += `<p class="${cssCls}"><strong>${message}</strong></p>`;

			button.removeAttribute("disabled");

			setTimeout(() => { alert.classList.add("hidden"); }, 10000);

			loader.classList.add("hidden");

			if (!success) return;

			Cookies.set("token", token);

			window.location.href = "http://sqlwork/src/pages/home-page.php";
		});
});