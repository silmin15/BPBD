document.addEventListener("DOMContentLoaded", function () {
    const centerLat = -7.4021;
    const centerLng = 109.5515;
    const initialZoom = 11;

    const map = L.map("map").setView([centerLat, centerLng], initialZoom);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    // Inisialisasi layer group untuk marker kejadian bencana
    const markersLayer = L.layerGroup().addTo(map);
    
    // Fungsi untuk memuat data kejadian bencana dari API
    function loadKejadianBencana(filters = {}) {
        // Reset layer marker
        markersLayer.clearLayers();
        
        // Buat query string dari filter
        const queryParams = new URLSearchParams();
        if (filters.jenis_bencana_id) queryParams.append('jenis_bencana_id', filters.jenis_bencana_id);
        if (filters.kecamatan) queryParams.append('kecamatan', filters.kecamatan);
        if (filters.start_date) queryParams.append('start_date', filters.start_date);
        if (filters.end_date) queryParams.append('end_date', filters.end_date);
        
        // Ambil data dari API
        fetch(`/api/kejadian-bencana?${queryParams.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tambahkan marker untuk setiap kejadian bencana
                    data.data.forEach(kejadian => {
                        const marker = L.marker([kejadian.latitude, kejadian.longitude])
                            .addTo(markersLayer);
                            
                        // Format tanggal dan waktu
                        const tanggal = new Date(kejadian.tanggal).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        const waktu = kejadian.waktu.substring(0, 5); // Format HH:MM
                        
                        // Buat konten popup
                        const popupContent = `
                            <div class="popup-content">
                                <h5>${kejadian.judul}</h5>
                                <p><strong>Jenis Bencana:</strong> ${kejadian.jenis_bencana.nama}</p>
                                <p><strong>Lokasi:</strong> ${kejadian.alamat}</p>
                                <p><strong>Kecamatan:</strong> ${kejadian.kecamatan}</p>
                                <p><strong>Waktu Kejadian:</strong> ${tanggal}, ${waktu} WIB</p>
                                ${kejadian.keterangan ? `<p><strong>Keterangan:</strong> ${kejadian.keterangan}</p>` : ''}
                            </div>
                        `;
                        
                        marker.bindPopup(popupContent);
                    });
                    
                    // Jika ada data, zoom ke batas semua marker
                    if (data.data.length > 0) {
                        const bounds = L.latLngBounds(data.data.map(item => [item.latitude, item.longitude]));
                        map.fitBounds(bounds, { padding: [50, 50] });
                    }
                } else {
                    console.error('Gagal memuat data kejadian bencana');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // Fungsi untuk memuat filter jenis bencana
    function loadJenisBencanaFilter() {
        const filterContainer = document.getElementById('filter-jenis-bencana');
        if (!filterContainer) return;
        
        fetch('/api/kejadian-bencana/jenis-bencana')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let html = '<option value="">Semua Jenis Bencana</option>';
                    data.data.forEach(jenis => {
                        html += `<option value="${jenis.id}">${jenis.nama}</option>`;
                    });
                    filterContainer.innerHTML = html;
                    
                    // Tambahkan event listener untuk perubahan filter
                    filterContainer.addEventListener('change', applyFilters);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // Fungsi untuk memuat filter kecamatan
    function loadKecamatanFilter() {
        const filterContainer = document.getElementById('filter-kecamatan');
        if (!filterContainer) return;
        
        fetch('/api/kejadian-bencana/kecamatan')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    let html = '<option value="">Semua Kecamatan</option>';
                    data.data.forEach(kecamatan => {
                        html += `<option value="${kecamatan}">${kecamatan}</option>`;
                    });
                    filterContainer.innerHTML = html;
                    
                    // Tambahkan event listener untuk perubahan filter
                    filterContainer.addEventListener('change', applyFilters);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    
    // Fungsi untuk menerapkan filter
    function applyFilters() {
        const jenisBencana = document.getElementById('filter-jenis-bencana')?.value || '';
        const kecamatan = document.getElementById('filter-kecamatan')?.value || '';
        const startDate = document.getElementById('filter-start-date')?.value || '';
        const endDate = document.getElementById('filter-end-date')?.value || '';
        
        loadKejadianBencana({
            jenis_bencana_id: jenisBencana,
            kecamatan: kecamatan,
            start_date: startDate,
            end_date: endDate
        });
    }
    
    // Tambahkan event listener untuk filter tanggal
    document.getElementById('filter-start-date')?.addEventListener('change', applyFilters);
    document.getElementById('filter-end-date')?.addEventListener('change', applyFilters);
    
    // Tambahkan event listener untuk tombol reset filter
    document.getElementById('reset-filter')?.addEventListener('click', function() {
        // Reset semua filter
        if (document.getElementById('filter-jenis-bencana')) document.getElementById('filter-jenis-bencana').value = '';
        if (document.getElementById('filter-kecamatan')) document.getElementById('filter-kecamatan').value = '';
        if (document.getElementById('filter-start-date')) document.getElementById('filter-start-date').value = '';
        if (document.getElementById('filter-end-date')) document.getElementById('filter-end-date').value = '';
        
        // Muat ulang data
        loadKejadianBencana();
    });
    
    // Inisialisasi filter dan muat data
    loadJenisBencanaFilter();
    loadKecamatanFilter();
    loadKejadianBencana();
});
