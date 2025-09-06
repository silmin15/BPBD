import { ready } from "../../../modules/domReady";

ready(() => {
    const form = document.getElementById("form-selected");
    const topPrintBtn = document.getElementById("top-print-selected");
    const bottomPrintBtn = document.getElementById("bottom-print-selected"); // opsional
    const checkAll = document.getElementById("check-all");

    // Kalau elemen kunci tidak ada, biarkan saja (hindari error)
    if (!form || !checkAll) return;

    const getRows = () => form.querySelectorAll(".row-check");
    const getChecked = () => form.querySelectorAll(".row-check:checked");

    const setDisabled = (btn, disabled) => {
        if (!btn) return;
        btn.disabled = disabled;
    };

    const updateUI = () => {
        const total = getRows().length;
        const checked = getChecked().length;

        // enable / disable tombol cetak (atas & bawah jika ada)
        const shouldDisable = checked === 0;
        setDisabled(topPrintBtn, shouldDisable);
        setDisabled(bottomPrintBtn, shouldDisable);

        // status check-all
        checkAll.checked = checked > 0 && checked === total;
        checkAll.indeterminate = checked > 0 && checked < total;
    };

    // klik check-all
    checkAll.addEventListener("change", (e) => {
        getRows().forEach((c) => {
            c.checked = e.target.checked;
        });
        updateUI();
    });

    // perubahan tiap row
    getRows().forEach((c) => c.addEventListener("change", updateUI));

    // initial state
    updateUI();

    // ====== (Opsional) Sinkronkan tombol aksi header sesuai tab aktif ======
    // Kalau kamu pakai wrapper #sk-page dengan data-active-tab
    const root = document.getElementById("sk-page");
    const activeTab = root?.dataset?.activeTab;
    if (activeTab) {
        document
            .querySelectorAll("#tab-actions [data-action]")
            .forEach((el) => {
                el.classList.toggle(
                    "d-none",
                    el.getAttribute("data-action") !== activeTab
                );
            });
    }
});
