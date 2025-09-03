import { ready } from "../../../modules/domReady";

ready(() => {
    const el = document.getElementById("createUserModal");
    if (!el || typeof bootstrap === "undefined") return;

    // buka otomatis kalau ada error di dalam modal
    const hasInvalid = !!el.querySelector(".is-invalid");
    if (hasInvalid) {
        const modal = new bootstrap.Modal(el);
        modal.show();
        setTimeout(() => {
            const firstInvalid = el.querySelector(".is-invalid");
            if (firstInvalid) firstInvalid.focus();
        }, 300);
    }
});
