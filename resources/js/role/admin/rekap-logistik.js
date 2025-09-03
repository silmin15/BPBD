import { ready } from "../../modules/domReady";

ready(() => {
    // --- FILTER OVERLAY ---
    const openBtn = document.getElementById("open-filter");
    const closeBtn = document.getElementById("close-filter");
    const cancelBtn = document.getElementById("cancel-filter");
    const overlay = document.getElementById("filter-overlay");

    if (overlay) {
        const open = () => overlay.setAttribute("aria-hidden", "false");
        const close = () => overlay.setAttribute("aria-hidden", "true");

        openBtn?.addEventListener("click", open);
        closeBtn?.addEventListener("click", close);
        cancelBtn?.addEventListener("click", close);

        // klik backdrop untuk tutup
        overlay.addEventListener("click", (e) => {
            if (e.target.id === "filter-overlay") close();
        });

        // esc key
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") close();
        });
    }

    // --- PILIH SEMUA CHECKBOX ---
    const checkAll = document.getElementById("check-all");
    const rowChecks = document.querySelectorAll(".row-check");
    const printBtn = document.getElementById("top-print-selected");

    function updateState() {
        const checked = document.querySelectorAll(".row-check:checked");
        printBtn.disabled = checked.length === 0;
        const info = document.getElementById("selected-count");
        if (info) info.textContent = `${checked.length} dipilih`;
    }

    if (checkAll) {
        checkAll.addEventListener("change", () => {
            rowChecks.forEach((cb) => (cb.checked = checkAll.checked));
            updateState();
        });
    }
    rowChecks.forEach((cb) => cb.addEventListener("change", updateState));

    // --- CETAK PDF (APPLY FILTER & PRINT) ---
    const applyPrint = document.getElementById("apply-print");
    if (applyPrint) {
        applyPrint.addEventListener("click", () => {
            const url = applyPrint.dataset.pdfUrl;
            const form = document.getElementById("filter-form");
            if (!form) return;

            // Kirim filter sebagai query string
            const params = new URLSearchParams(new FormData(form));
            const link = `${url}?${params.toString()}`;

            window.open(link, "_blank");
        });
    }

    console.debug("[BPBD] Rekap Logistik JS ready");
});
