import { ready } from "../../../modules/domReady";

ready(() => {
    const tbody = document.getElementById("tbody");
    const addBtn = document.getElementById("btnAdd");
    if (!tbody || !addBtn) return;

    let rowCount = 0;

    function fmt(n) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        }).format(n || 0);
    }

    function recalcFooters() {
        let sumJumlah = 0,
            sumKeluar = 0,
            sumSisa = 0;
        tbody.querySelectorAll("tr[data-row]").forEach((tr) => {
            sumJumlah += +(tr.querySelector(".inp-jumlah-harga")?.value || 0);
            sumKeluar += +(tr.querySelector(".inp-keluar-harga")?.value || 0);
            sumSisa += +(tr.querySelector(".inp-sisa-harga")?.value || 0);
        });
        const setTxt = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.textContent = fmt(val);
        };
        setTxt("ft_jumlah_harga", sumJumlah);
        setTxt("ft_keluar_harga", sumKeluar);
        setTxt("ft_sisa_harga", sumSisa);
    }

    function recalcRow(tr) {
        const vol = +(tr.querySelector(".inp-volume")?.value || 0);
        const hSat = +(tr.querySelector(".inp-harga-sat")?.value || 0);
        const keluar = +(tr.querySelector(".inp-keluar")?.value || 0);

        const jumlahHarga = vol * hSat;
        const keluarHarga = keluar * hSat;
        const sisaBarang = Math.max(vol - keluar, 0);
        const sisaHarga = sisaBarang * hSat;

        tr.querySelector(".inp-jumlah-harga").value = jumlahHarga;
        tr.querySelector(".inp-keluar-harga").value = keluarHarga;
        tr.querySelector(".inp-sisa-barang").value = sisaBarang;
        tr.querySelector(".inp-sisa-harga").value = sisaHarga;

        // tampilkan ke sel text jika ada span dsb (opsional)
        recalcFooters();
    }

    function bindRowEvents(tr) {
        ["input", "change"].forEach((evt) => {
            tr.addEventListener(evt, (e) => {
                if (
                    e.target.matches(".inp-volume, .inp-harga-sat, .inp-keluar")
                )
                    recalcRow(tr);
            });
        });
        tr.querySelector(".btn-remove")?.addEventListener("click", (e) => {
            e.preventDefault();
            tr.remove();
            renumber();
            recalcFooters();
        });
    }

    function renumber() {
        [...tbody.querySelectorAll("tr[data-row]")].forEach((tr, i) => {
            tr.querySelector(".col-no").textContent = i + 1;
        });
    }

    function addRow() {
        const idx = rowCount++;
        const tr = document.createElement("tr");
        tr.setAttribute("data-row", idx);
        tr.innerHTML = `
      <td class="text-center col-no"></td>
      <td><input name="items[${idx}][nama_barang]" class="form-control" required></td>
      <td><input type="number" step="1" min="0" name="items[${idx}][volume]" class="form-control inp-volume" value="0"></td>
      <td><input name="items[${idx}][satuan]" class="form-control"></td>
      <td><input type="number" step="1" min="0" name="items[${idx}][harga_satuan]" class="form-control inp-harga-sat" value="0"></td>
      <td><input type="number" name="items[${idx}][jumlah_harga]" class="form-control inp-jumlah-harga" value="0" readonly></td>
      <td><input type="number" step="1" min="0" name="items[${idx}][jumlah_keluar]" class="form-control inp-keluar" value="0"></td>
      <td><input type="number" name="items[${idx}][jumlah_harga_keluar]" class="form-control inp-keluar-harga" value="0" readonly></td>
      <td><input type="number" name="items[${idx}][sisa_barang]" class="form-control inp-sisa-barang" value="0" readonly></td>
      <td><input type="number" name="items[${idx}][sisa_harga]" class="form-control inp-sisa-harga" value="0" readonly></td>
      <td class="text-center">
        <button class="btn btn-sm btn-light btn-remove" type="button" title="Hapus baris">
          <i class="bi bi-x-lg"></i>
        </button>
      </td>`;
        tbody.appendChild(tr);
        renumber();
        bindRowEvents(tr);
        recalcRow(tr);
    }

    addBtn.addEventListener("click", addRow);

    // tambah 1 baris awal kalau kosong
    if (!tbody.querySelector("[data-row]")) addRow();
});
