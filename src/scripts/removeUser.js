"use strict";

const alert = document.querySelector(".alert");
const loader = document.querySelector(".loader");

export default function (event) {
	const removed_id = event.target.parentNode.dataset.id;

	const obj = {
		removed_id,
		token: Cookies.get("token")
	};

	fetch("../logics/user/removeById.php", {
		method: "DELETE",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify(obj)
	})
		.then((response) => response.json())
		.then((data) => {
			const { message, success, redirect } = data;

			if (redirect) {
				Cookies.remove("token");
				window.location.href = "http://sqlwork/src/pages/login-page.php";
			}

			let cssCls = "success";

			if (!success) cssCls = "error";

			alert.innerHTML += `<p class="${cssCls}"><strong>${message}</strong></p>`;

			setTimeout(() => { alert.classList.add("hidden"); }, 10000);

			loader.classList.add("hidden");

			if (!success) return;

			document.querySelector(`#users-list li[data-id='${removed_id}']`).remove();
		});
}