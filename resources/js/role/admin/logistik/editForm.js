// Halaman LOGISTIK EDIT: single row kalkulasi
import { ready } from '../domReady';

ready(() => {
  const form = document.getElementById('formLogistik');
  if (!form) return;
  if (document.getElementById('tbody')) return; // create sudah handle

  const $ = (sel) => form.querySelector(sel);

  function recalc() {
    const vol    = Number($('[name="volume"]')?.value || 0);
    const harga  = Number($('[name="harga_satuan"]')?.value || 0);
    const keluar = Number($('[name="jumlah_keluar"]')?.value || 0);

    const jumlahHarga = vol * harga;
    const keluarHarga = keluar * harga;
    const sisaBarang  = Math.max(vol - keluar, 0);
    const sisaHarga   = sisaBarang * harga;

    $('[name="jumlah_harga"]').value         = jumlahHarga.toFixed(2);
    $('[name="jumlah_harga_keluar"]').value  = keluarHarga.toFixed(2);
    $('[name="sisa_barang"]').value          = Math.round(sisaBarang);
    $('[name="sisa_harga"]').value           = sisaHarga.toFixed(2);
  }

  form.querySelectorAll('.calc').forEach(el => el.addEventListener('input', recalc));
  recalc();
});
