import { ready } from "../../../modules/domReady";

ready(() => {
    const form = document.getElementById("form-selected");
    const topPrintBtn = document.getElementById("top-print-selected");
    const checkAll = document.getElementById("check-all");
    if (!form || !topPrintBtn || !checkAll) return;

    const getRows = () => form.querySelectorAll(".row-check");
    const getChecked = () => form.querySelectorAll(".row-check:checked");

    const updateUI = () => {
        const total = getRows().length;
        const checked = getChecked().length;

        // enable / disable tombol
        topPrintBtn.disabled = checked === 0;

        // update status check-all
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
});
