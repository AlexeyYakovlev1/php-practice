"use strict";

import removeUser from "./removeUser.js";

window.addEventListener("DOMContentLoaded", () => {
	const token = Cookies.get("token");

	fetch("../logics/user/getAll.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({ token })
	})
		.then((response) => response.json())
		.then((data) => {
			data.forEach(({ id, name, email, avatar }) => {
				document.querySelector("#users-list").insertAdjacentHTML("beforeend", `
					<li data-id='${id}'>
						<img src="${avatar}" alt="Avatar ${name}" width="50" height="50" />
						<div class='user-content'>
							<h3>Name: ${name}</h3>
							<span>Email: ${email}</span>
						</div>
						<button id='remove-btn'>Remove this user</button>
					</li>
				`);
			});

			const removeBtns = document.querySelectorAll("#remove-btn");

			removeBtns.forEach((btn) => {
				btn.addEventListener("click", (event) => { removeUser(event); });
			});
		});
});