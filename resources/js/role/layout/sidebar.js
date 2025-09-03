import { ready } from "../../modules/domReady";

ready(() => {
    const sidebar = document.getElementById("main-sidebar");
    const backdrop = document.getElementById("sidebar-backdrop");
    const main = document.getElementById("main-content"); // tetap dipakai kalau perlu
    const topbarPad = document.getElementById("topbar-pad"); // opsional
    const mq = window.matchMedia("(min-width: 768px)");
    const toggles = document.querySelectorAll("[data-sidebar-toggle]");

    if (!sidebar) return;

    /** -------- Helpers -------- */
    const openDesktop = () => {
        // Desktop: geser layout via CSS (tanpa backdrop)
        document.body.classList.add("with-sidebar");
        backdrop?.classList.remove("is-visible");
        sidebar.classList.remove("is-open"); // pastikan tidak di mode mobile
        document.body.style.overflow = "";
    };

    const closeDesktop = () => {
        document.body.classList.remove("with-sidebar");
    };

    const openMobile = () => {
        // Mobile: off-canvas + backdrop
        sidebar.classList.add("is-open");
        backdrop?.classList.add("is-visible");
        document.body.style.overflow = "hidden";
    };

    const closeMobile = () => {
        sidebar.classList.remove("is-open");
        backdrop?.classList.remove("is-visible");
        document.body.style.overflow = "";
    };

    const isDesktop = () => mq.matches;

    /** -------- Public actions -------- */
    const openSidebar = () => (isDesktop() ? openDesktop() : openMobile());
    const closeSidebar = () => (isDesktop() ? closeDesktop() : closeMobile());

    const toggleSidebar = () => {
        if (isDesktop()) {
            // di desktop: toggle flag pada body
            document.body.classList.toggle("with-sidebar");
        } else {
            // di mobile: toggle off-canvas
            const opened = sidebar.classList.contains("is-open");
            opened ? closeMobile() : openMobile();
        }
    };

    /** -------- Bindings -------- */
    toggles.forEach((btn) => btn.addEventListener("click", toggleSidebar));
    backdrop?.addEventListener("click", closeSidebar);
    document.addEventListener(
        "keydown",
        (e) => e.key === "Escape" && closeSidebar()
    );

    /** -------- Sync on load & resize -------- */
    const sync = () => {
        if (isDesktop()) {
            // default: sidebar aktif (layout geser)
            openDesktop();
        } else {
            // default: sidebar tertutup (off-canvas)
            closeMobile();
        }
    };
    mq.addEventListener
        ? mq.addEventListener("change", sync)
        : mq.addListener(sync);
    sync();

    console.debug("[BPBD] sidebar ready", { toggles: toggles.length });
});
