"use strict";

const logout = document.querySelector(".logout");

logout.addEventListener("click", () => {
	Cookies.remove("token");
	window.location.href = "http://sqlwork/src/pages/login-page.php";
});