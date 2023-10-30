"use strict";

window.addEventListener("DOMContentLoaded", () => {
	const token = Cookies.get("token");

	fetch("../logics/user/getData.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({ token })
	})
		.then((response) => response.json())
		.then((data) => {
			const { email, name, avatar, description } = data;

			document.title = name;

			document.querySelector("#name").textContent = name;
			document.querySelector("#email").textContent = email;
			document.querySelector("#avatar").src = avatar;
			document.querySelector("#description").textContent = description;
		});
});