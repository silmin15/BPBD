import { ready } from "../modules/domReady";

ready(() => {
    const loginForm = document.getElementById("loginFormModal");
    if (!loginForm) return;

    loginForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const emailError = document.getElementById("email-error");
        const passwordError = document.getElementById("password-error");
        const generalError = document.getElementById("login-error-alert");

        if (emailError) emailError.textContent = "";
        if (passwordError) passwordError.textContent = "";
        if (generalError) {
            generalError.classList.add("d-none");
            generalError.textContent = "";
        }

        const formData = new FormData(loginForm);

        fetch(loginForm.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
                Accept: "application/json",
            },
            body: formData,
        })
            .then((res) =>
                res.ok
                    ? res.json()
                    : res.json().then((err) => {
                          throw err;
                      })
            )
            .then((data) => {
                if (data?.status === "success" && data?.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            })
            .catch((error) => {
                const g = document.getElementById("login-error-alert");
                const e = document.getElementById("email-error");
                if (g) {
                    g.classList.add("d-none");
                    g.textContent = "";
                }
                if (e) e.textContent = "";

                if (error?.errors?.email?.[0]) {
                    if (e) e.textContent = error.errors.email[0];
                } else if (error?.message && g) {
                    g.textContent = error.message;
                    g.classList.remove("d-none");
                }
            });
    });
});
