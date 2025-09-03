import { ready } from '../domReady';

ready(() => {
  const date = document.getElementById('tanggal_sk');
  const bulanText = document.getElementById('bulan_text');
  if (!date || !bulanText) return;

  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

  const fill = () => {
    const d = new Date(date.value);
    if (!isNaN(d)) bulanText.value = bulan[d.getMonth()];
  };

  date.addEventListener('change', fill);
  if (date.value && !bulanText.value) fill();
});
