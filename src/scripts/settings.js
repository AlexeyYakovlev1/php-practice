"use strict";

const form = document.querySelector(".form");
const alert = document.querySelector(".alert");

const token = Cookies.get("token");

window.addEventListener("DOMContentLoaded", () => {
	// Init data for inputs
	fetch("../logics/user/getData.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({ token })
	})
		.then((response) => response.json())
		.then((data) => {
			for (const el in data) {
				if (data.hasOwnProperty(el)) {
					const input = document.querySelector(`.form__${el}`);

					if (!input) continue;

					input.value = data[el];
				}
			}

			document.querySelector(".img-avatar").src = data.avatar;
		});
});

// Change data when click on button
form.addEventListener("submit", (event) => {
	event.preventDefault();

	const obj = {
		email: document.querySelector(".form__email").value,
		avatar: document.querySelector(".form__avatar").value,
		name: document.querySelector(".form__name").value,
		description: document.querySelector(".form__description").value,
		token
	};

	fetch("../logics/user/changeData.php", {
		method: "PUT",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify(obj)
	})
		.then((response) => response.json())
		.then((data) => {
			const { message, success } = data;

			let cssCls = "success";

			if (!success) cssCls = "error";

			alert.innerHTML += `<p class="${cssCls}"><strong>${message}</strong></p>`;

			setTimeout(() => { alert.classList.add("hidden"); }, 10000);
		});
});