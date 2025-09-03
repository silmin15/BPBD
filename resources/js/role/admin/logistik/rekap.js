// resources/js/logistik/rekap.js
import { ready } from "../../../modules/domReady"; 

ready(() => {
    // ===== Node refs =====
    const overlay = document.getElementById("filter-overlay");
    const openBtn = document.getElementById("open-filter");
    const closeBtn = document.getElementById("close-filter");
    const cancelBtn = document.getElementById("cancel-filter");
    const formFilter = document.getElementById("filter-form");
    const applyPrintBtn = document.getElementById("apply-print");

    const selectedForm = document.getElementById("form-selected"); // form untuk Cetak (Yang Dipilih)
    const topPrintBtn = document.getElementById("top-print-selected"); // tombol Cetak (Yang Dipilih)
    const globalCheck = document.getElementById("check-all-global"); // master check-all
    const selectedCount = document.getElementById("selected-count"); // counter "Terpilih: X"

    // scope pencarian checkbox baris
    const scope = selectedForm || document;

    // ===== Util checkbox =====
    const rowSelector =
        '.row-check[name="selected_ids[]"], .row-check[name="ids[]"], .row-check';
    const getRowChecks = () => Array.from(scope.querySelectorAll(rowSelector));
    const getChecked = () => getRowChecks().filter((c) => c.checked);
    const getByMonth = (ym) =>
        getRowChecks().filter((r) => r.dataset.month === ym);

    const monthMasters = () =>
        Array.from(document.querySelectorAll(".check-all-month"));

    function refreshCounterAndButtons() {
        const n = getChecked().length;
        if (selectedCount) selectedCount.textContent = String(n);
        if (topPrintBtn) topPrintBtn.disabled = n === 0;
    }

    function syncGlobalMaster() {
        if (!globalCheck) return;
        const rows = getRowChecks();
        if (rows.length === 0) {
            globalCheck.indeterminate = false;
            globalCheck.checked = false;
            return;
        }
        const checked = rows.filter((c) => c.checked).length;
        globalCheck.indeterminate = checked > 0 && checked < rows.length;
        globalCheck.checked = checked === rows.length;
    }

    function syncMonthMasters() {
        monthMasters().forEach((m) => {
            const ym = m.dataset.month;
            const rows = getByMonth(ym);
            if (rows.length === 0) {
                m.indeterminate = false;
                m.checked = false;
                return;
            }
            const checked = rows.filter((r) => r.checked).length;
            m.indeterminate = checked > 0 && checked < rows.length;
            m.checked = checked === rows.length;
        });
    }

    function refreshAllUI() {
        refreshCounterAndButtons();
        syncMonthMasters();
        syncGlobalMaster();
    }

    // ===== Overlay (Filter) =====
    if (overlay && openBtn && formFilter) {
        const open = () => {
            overlay.removeAttribute("hidden"); // penting: hilangkan display:none
            overlay.classList.add("show");
            overlay.removeAttribute("aria-hidden");
            document.body.style.overflow = "hidden";
            formFilter.querySelector("input,select,textarea,button")?.focus();
        };
        const close = () => {
            overlay.classList.remove("show");
            overlay.setAttribute("aria-hidden", "true");
            overlay.setAttribute("hidden", ""); // sembunyikan lagi
            document.body.style.overflow = "";
            openBtn?.focus();
        };

        openBtn.addEventListener("click", open);
        closeBtn?.addEventListener("click", close);
        cancelBtn?.addEventListener("click", (e) => {
            e.preventDefault();
            close();
        });
        overlay.addEventListener("click", (e) => {
            if (e.target === overlay) close();
        });
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape" && overlay.classList.contains("show"))
                close();
        });

        // Apply & Print (hasil filter → PDF di tab baru)
        applyPrintBtn?.addEventListener("click", () => {
            const pdfUrl =
                applyPrintBtn.dataset.pdfUrl || formFilter.dataset.pdfUrl;
            if (!pdfUrl) return;
            const oldAction = formFilter.action,
                oldTarget = formFilter.target;
            formFilter.action = pdfUrl;
            formFilter.target = "_blank";
            formFilter.submit();
            formFilter.action = oldAction;
            formFilter.target = oldTarget || "";
        });
    }

    // ===== Event: perubahan checkbox baris (delegation) =====
    scope.addEventListener("change", (e) => {
        if (e.target.matches(rowSelector)) {
            refreshAllUI();
        }
    });

    // ===== Global "Pilih Semua (Semua Bulan)" =====
    globalCheck?.addEventListener("change", (e) => {
        const state = e.target.checked;
        getRowChecks().forEach((c) => {
            c.checked = state;
        });
        monthMasters().forEach((m) => {
            m.checked = state;
            m.indeterminate = false;
        });
        refreshAllUI();
    });

    // ===== "Pilih semua per-bulan" (opsional; kalau kamu pakai di judul bulan) =====
    monthMasters().forEach((monthCheck) => {
        monthCheck.addEventListener("change", (e) => {
            const ym = e.currentTarget.dataset.month;
            const state = e.currentTarget.checked;
            getByMonth(ym).forEach((r) => {
                r.checked = state;
            });
            refreshAllUI();
        });
    });

    // ===== Inisialisasi tampilan =====
    refreshAllUI();
});
