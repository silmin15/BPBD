import { ready } from "../../modules/domReady";

ready(() => {
    console.log("✅ Dropdown script aktif");
    const btn = document.getElementById("topbar-profile-btn");
    const menu = document.getElementById("topbar-profile-menu");
    console.log("btn:", btn, "menu:", menu); // cek ketemu atau nggak

    if (!btn || !menu) return;

    btn.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
        if (
            !menu.classList.contains("hidden") &&
            !menu.contains(e.target) &&
            e.target !== btn
        ) {
            menu.classList.add("hidden");
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            menu.classList.add("hidden");
        }
    });
});
console.log("🔥 profileMenu.js masuk bundle");
