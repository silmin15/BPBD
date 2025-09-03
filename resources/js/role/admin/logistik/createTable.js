// Halaman LOGISTIK CREATE: tabel dinamis batch
import { ready } from '../domReady';

ready(() => {
  const form  = document.getElementById('formLogistik');
  const tbody = document.getElementById('tbody');
  const addBtn= document.getElementById('btnAdd');
  if (!form || !tbody || !addBtn) return; // bukan halaman create

  const fmtIDR = (n) => 'Rp ' + Number(n || 0).toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

  const rowTemplate = (i) => `
    <tr data-i="${i}">
      <td class="text-center align-middle">${i + 1}</td>
      <td><input name="items[${i}][nama_barang]" class="form-control" required></td>
      <td><input name="items[${i}][volume]" type="number" min="0" step="1" class="form-control calc" value="0" required></td>
      <td><input name="items[${i}][satuan]" class="form-control" placeholder="Lembar/Kg" required></td>
      <td><input name="items[${i}][harga_satuan]" type="number" min="0" step="0.01" class="form-control calc" value="0" required></td>
      <td><input name="items[${i}][jumlah_harga]" type="number" step="0.01" class="form-control" value="0" readonly></td>
      <td><input name="items[${i}][jumlah_keluar]" type="number" min="0" step="1" class="form-control calc" value="0"></td>
      <td><input name="items[${i}][jumlah_harga_keluar]" type="number" step="0.01" class="form-control" value="0" readonly></td>
      <td><input name="items[${i}][sisa_barang]" type="number" step="1" class="form-control" value="0" readonly></td>
      <td><input name="items[${i}][sisa_harga]" type="number" step="0.01" class="form-control" value="0" readonly></td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger btnDel"><i class="bi bi-trash"></i></button>
      </td>
    </tr>`;

  const g = (tr, n) => tr.querySelector(`[name$="[${n}]"]`);

  function recalcRow(tr) {
    const vol    = +g(tr, 'volume')?.value || 0;
    const harga  = +g(tr, 'harga_satuan')?.value || 0;
    const keluar = +g(tr, 'jumlah_keluar')?.value || 0;

    const jumlahHarga = vol * harga;
    const keluarHarga = keluar * harga;
    const sisaBarang  = Math.max(vol - keluar, 0);
    const sisaHarga   = sisaBarang * harga;

    g(tr, 'jumlah_harga').value         = jumlahHarga.toFixed(2);
    g(tr, 'jumlah_harga_keluar').value  = keluarHarga.toFixed(2);
    g(tr, 'sisa_barang').value          = Math.round(sisaBarang);
    g(tr, 'sisa_harga').value           = sisaHarga.toFixed(2);
  }

  function recalcFooter() {
    let jh = 0, kh = 0, sh = 0;
    tbody.querySelectorAll('tr').forEach(tr => {
      jh += +g(tr, 'jumlah_harga')?.value || 0;
      kh += +g(tr, 'jumlah_harga_keluar')?.value || 0;
      sh += +g(tr, 'sisa_harga')?.value || 0;
    });
    const J = document.getElementById('ft_jumlah_harga');
    const K = document.getElementById('ft_keluar_harga');
    const S = document.getElementById('ft_sisa_harga');
    if (J) J.textContent = fmtIDR(jh);
    if (K) K.textContent = fmtIDR(kh);
    if (S) S.textContent = fmtIDR(sh);
  }

  function bindRow(tr) {
    tr.querySelectorAll('.calc').forEach(el =>
      el.addEventListener('input', () => { recalcRow(tr); recalcFooter(); })
    );
    tr.querySelector('.btnDel')?.addEventListener('click', () => {
      tr.remove(); renumber(); recalcFooter();
    });
    recalcRow(tr);
  }

  function addRow() {
    const i = tbody.querySelectorAll('tr').length;
    tbody.insertAdjacentHTML('beforeend', rowTemplate(i));
    bindRow(tbody.querySelector('tr:last-child'));
  }

  function renumber() {
    [...tbody.querySelectorAll('tr')].forEach((tr, idx) => {
      tr.dataset.i = idx;
      tr.children[0].textContent = idx + 1;
      tr.querySelectorAll('input').forEach(inp => {
        const name = inp.getAttribute('name').replace(/items\[\d+\]/, `items[${idx}]`);
        inp.setAttribute('name', name);
      });
    });
  }

  // init
  addRow(); addRow(); addRow();
  addBtn.addEventListener('click', addRow);
});
