import "./bootstrap";
import "bootstrap";

// import Alpine from "alpinejs";

// Login
const loginForm = document.getElementById("loginFormModal");

if (loginForm) {
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const emailError = document.getElementById("email-error");
        const passwordError = document.getElementById("password-error");
        const generalError = document.getElementById("login-error-alert");

        emailError.textContent = "";
        passwordError.textContent = "";
        generalError.classList.add("d-none");
        generalError.textContent = "";

        const formData = new FormData(loginForm);

        fetch(loginForm.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((err) => {
                        throw err;
                    });
                }
                return response.json(); // Pastikan ada .json() di sini
            })
            .then((data) => {
                // LOGIKA BARU: Cek status dan gunakan redirect_url dari API
                if (data.status === "success" && data.redirect_url) {
                    // Arahkan ke URL yang diberikan oleh backend
                    window.location.href = data.redirect_url;
                }
            })
            .catch((error) => {
                // Ganti logika penanganan error agar lebih sederhana
                const generalError =
                    document.getElementById("login-error-alert");
                const emailError = document.getElementById("email-error");

                generalError.classList.add("d-none");
                emailError.textContent = "";

                if (error.errors && error.errors.email) {
                    // Jika ada error validasi di field email
                    emailError.textContent = error.errors.email[0];
                } else if (error.message) {
                    // Untuk error umum lainnya
                    generalError.textContent = error.message;
                    generalError.classList.remove("d-none");
                }
            });
    });
}

// window.Alpine = Alpine;

// Alpine.start();
