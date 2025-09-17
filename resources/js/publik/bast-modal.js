document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("bastModal");
    if (!modal) return;

    const desaUrl = modal.dataset.desaUrl;
    const kec = document.getElementById("inputKecamatan");
    const list = document.getElementById("listDesa");
    if (!kec || !list || !desaUrl) {
        console.warn("BAST: element/URL tidak ditemukan", {
            kec: !!kec,
            list: !!list,
            desaUrl,
        });
        return;
    }

    async function loadDesa(val) {
        list.innerHTML = "";
        const q = (val || "").trim();
        if (!q) return;

        try {
            const res = await fetch(
                `${desaUrl}?kecamatan=${encodeURIComponent(q)}`,
                {
                    headers: { Accept: "application/json" },
                }
            );
            if (!res.ok) return;
            const data = await res.json();
            list.innerHTML = (data.desa || [])
                .map((n) => `<option value="${n}"></option>`)
                .join("");
        } catch (e) {
            console.warn("BAST: gagal fetch desa", e);
        }
    }

    ["input", "change", "blur"].forEach((ev) =>
        kec.addEventListener(ev, (e) => loadDesa(e.target.value))
    );

    // Saat modal dibuka, isi list desa sesuai nilai kecamatan saat ini (jika ada)
    modal.addEventListener("shown.bs.modal", () => loadDesa(kec.value));
});
