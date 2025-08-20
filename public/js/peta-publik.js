document.addEventListener("DOMContentLoaded", function () {
    const centerLat = -7.4021;
    const centerLng = 109.5515;
    const initialZoom = 11;

    const map = L.map("map").setView([centerLat, centerLng], initialZoom);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(map);

    // (masih dummy ya let )
    // Marker (Titik)
    L.marker([-7.4915, 109.645])
        .addTo(map)
        .bindPopup("<b>Kejadian Bencana!</b><br>Contoh titik lokasi longsor.");

    //  Polygon
    const areaContohGeoJSON = {
        type: "Feature",
        properties: {},
        geometry: {
            type: "Polygon",
            coordinates: [
                [
                    [109.5, -7.35],
                    [109.55, -7.35],
                    [109.55, -7.4],
                    [109.5, -7.4],
                    [109.5, -7.35],
                ],
            ],
        },
    };

    L.geoJSON(areaContohGeoJSON, {
        style: {
            color: "red",
            weight: 2,
            fillOpacity: 0.3,
        },
    })
        .addTo(map)
        .bindPopup("Ini adalah contoh area terdampak.");
});
