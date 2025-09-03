// Modul peta publik
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('map');
  if (!el || typeof L === 'undefined') return;

  const map = L.map('map').setView([-7.379, 109.681], 11);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19,
  }).addTo(map);

  L.marker([-7.379, 109.681]).addTo(map).bindPopup('BPBD Banjarnegara').openPopup();
});
