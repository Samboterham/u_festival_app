<?php
// Map page now uses direct SVG image files from the images folder.
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Festival Map</title>
    <?php include 'theme-init.php' ?>
    <link rel="stylesheet" href="style.css" class="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sansation:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
    <style>
        .map-page {
            gap: 14px;
        }

        .map-header h1 {
            margin: 0 0 4px;
            font-size: 1.8rem;
            color: var(--color-brand);
        }

        .map-header p {
            margin: 0;
            color: var(--text-muted);
        }

        .map-tools {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .map-btn {
            border: none;
            border-radius: 999px;
            background: var(--color-cerulean);
            color: #fff;
            padding: 10px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .map-btn:hover {
            transform: translateY(-1px);
            filter: brightness(1.05);
        }

        .map-btn.secondary {
            background: var(--color-saffron);
            color: #000;
        }

        .gps-status {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .festival-map-wrap {
            position: relative;
            width: min(460px, 100%);
            aspect-ratio: 1353.19 / 2330.58;
            margin: 0 auto;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: #d9eef8;
            box-sizing: border-box;
        }

        .fullscreen-exit-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 30;
            display: none;
            border: none;
            border-radius: 999px;
            padding: 10px 14px;
            background: rgba(0, 0, 0, 0.72);
            color: #fff;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        .festival-map-wrap:fullscreen,
        .festival-map-wrap.is-fullscreen {
            width: 100vw;
            height: 100vh;
            max-width: 100vw;
            aspect-ratio: auto;
            border-radius: 0;
            border: none;
            margin: 0;
            background: #000;
            position: fixed;
            inset: 0;
            z-index: 9999;
        }

        .festival-map-wrap:fullscreen .festival-map-image,
        .festival-map-wrap.is-fullscreen .festival-map-image {
            width: 100%;
            height: 100%;
        }

        .festival-map-wrap:fullscreen .fullscreen-exit-btn,
        .festival-map-wrap.is-fullscreen .fullscreen-exit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .festival-map-image {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 177.99%;
            height: auto;
            display: block;
            transform: translate(-50%, -50%) rotate(90deg);
            transform-origin: center;
        }

        .map-marker {
            position: absolute;
            transform: translate(-50%, -50%);
            width: 30px;
            height: 30px;
            border: 3px solid #69008b;
            background: #d62e39;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            z-index: 5;
            display: grid;
            place-items: center;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .map-marker:hover,
        .map-marker.active {
            transform: translate(-50%, -50%) scale(1.14);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.28);
            filter: brightness(1.08);
        }

        .map-marker span {
            display: block;
            line-height: 1;
        }

        .map-info-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            width: min(940px, 100%);
            margin: 0 auto;
            box-sizing: border-box;
            overflow-wrap: anywhere;
        }

        .map-info-card h2 {
            margin: 0 0 8px;
            color: var(--color-brand);
            font-size: 1.15rem;
        }

        .map-info-card p {
            margin: 0 0 6px;
            font-weight: 400;
            line-height: 1.45;
        }

        .map-info-card a {
            color: var(--color-brand);
            word-break: break-word;
        }

        body.map-fullscreen header,
        body.map-fullscreen footer,
        body.map-fullscreen .map-header,
        body.map-fullscreen .map-tools,
        body.map-fullscreen .map-info-card {
            display: none !important;
        }

        body.map-fullscreen .map-page {
            padding: 0;
            min-height: 100vh;
            justify-content: center;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php' ?>
    </header>

    <main class="map-page">
        <section class="map-header">
            <h1>Festival Map</h1>
            <p>Tik op een marker voor info. Gebruik GPS om je afstand tot het festivalterrein te zien.</p>
        </section>

        <div class="map-tools">
            <button class="map-btn" id="findMeBtn" type="button">Gebruik mijn GPS locatie</button>
            <button class="map-btn secondary" id="fullscreenBtn" type="button">Fullscreen kaart</button>
            <span class="gps-status" id="gpsStatus">GPS nog niet geactiveerd.</span>
        </div>

        <div class="festival-map-wrap" id="mapWrap">
            <button class="fullscreen-exit-btn" id="exitFullscreenBtn" type="button">Verlaat fullscreen</button>
            <img class="festival-map-image" src="images/kaart_festival_markers (2).svg" alt="Festival terrein kaart">
        </div>

        <section class="map-info-card" id="infoCard" aria-live="polite">
            <h2>Festival kaart</h2>
            <p>Deze kaart bevat alle locaties en markers direct in het SVG-bestand.</p>
        </section>
    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>

    <script>
        const festivalLat = 52.0767408;
        const festivalLon = 5.1046989;

        // The map now uses a single combined SVG asset with baked-in markers.

        const locations = [
            { id: "stage1", label: "1", name: "Ponton", description: "Locatie 1: Ponton (main stage, hoofdacts).", tips: "Volg de hoofdpaden voor de beste toegang." },
            { id: "stage2", label: "2", name: "The Lake", description: "Locatie 2: The Lake (onbekend talent).", tips: "Perfect voor frisse beats en ontdekkingen." },
            { id: "stage3", label: "4", name: "Hangar", description: "Locatie 4: Hangar (non stop house/techno/dance).", tips: "Bereid je voor op een nacht vol energie." },
            { id: "stage4", label: "3", name: "The Club", description: "Locatie 3: The Club (theater en stand-up comedy).", tips: "Kom vroeg voor de beste zitplekken." }
        ];

        const markerPositions = {
            stage1: { x: 20.33, y: 62.79 },
            stage2: { x: 53.95, y: 45.49 },
            stage3: { x: 91.18, y: 16.10 },
            stage4: { x: 69.29, y: 39.06 }
        };
        const isVerticalMap = true;

        const mapWrap = document.getElementById("mapWrap");
        const infoCard = document.getElementById("infoCard");
        const gpsStatus = document.getElementById("gpsStatus");
        const findMeBtn = document.getElementById("findMeBtn");
        const fullscreenBtn = document.getElementById("fullscreenBtn");
        const exitFullscreenBtn = document.getElementById("exitFullscreenBtn");
        let fallbackFullscreen = false;

        function setInfo(location) {
            infoCard.innerHTML = `
                <h2>${location.label}. ${location.name}</h2>
                <p>${location.description}</p>
                <p><strong>Tip:</strong> ${location.tips}</p>
                <p><a href="https://www.google.com/maps/dir/?api=1&destination=${festivalLat},${festivalLon}" target="_blank" rel="noopener">Route naar festival in Google Maps</a></p>
            `;
        }

        function renderMarkers() {
            locations.forEach((location) => {
                const pos = markerPositions[location.id];
                if (!pos) return;
                const mappedPos = isVerticalMap ? { x: 100 - pos.y, y: pos.x } : pos;
                const marker = document.createElement("button");
                marker.type = "button";
                marker.className = "map-marker";
                marker.style.left = `${mappedPos.x}%`;
                marker.style.top = `${mappedPos.y}%`;
                marker.setAttribute("aria-label", `${location.name} info`);
                marker.innerHTML = `<span>${location.label}</span>`;

                marker.addEventListener("click", () => {
                    document.querySelectorAll(".map-marker").forEach((m) => m.classList.remove("active"));
                    marker.classList.add("active");
                    setInfo(location);
                });

                mapWrap.appendChild(marker);
            });
        }

        function toRad(value) {
            return (value * Math.PI) / 180;
        }

        function distanceInKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function handleGpsSuccess(position) {
            const { latitude, longitude } = position.coords;
            const km = distanceInKm(latitude, longitude, festivalLat, festivalLon);
            const kmText = km < 1 ? `${Math.round(km * 1000)} meter` : `${km.toFixed(1)} km`;
            gpsStatus.textContent = `Je bent ongeveer ${kmText} van het festivalterrein.`;

            const routeUrl = `https://www.google.com/maps/dir/?api=1&origin=${latitude},${longitude}&destination=${festivalLat},${festivalLon}`;
            infoCard.innerHTML = `
                <h2>GPS actief</h2>
                <p>Je locatie is gevonden. Afstand tot het festival: <strong>${kmText}</strong>.</p>
                <p><a href="${routeUrl}" target="_blank" rel="noopener">Open route vanaf mijn locatie</a></p>
            `;
        }

        function handleGpsError(error) {
            if (error.code === error.PERMISSION_DENIED) {
                gpsStatus.textContent = "GPS geweigerd. Sta locatie toe in je browser.";
                return;
            }
            gpsStatus.textContent = "GPS tijdelijk niet beschikbaar. Probeer opnieuw.";
        }

        findMeBtn.addEventListener("click", () => {
            if (!navigator.geolocation) {
                gpsStatus.textContent = "Deze browser ondersteunt geen GPS.";
                return;
            }

            gpsStatus.textContent = "Locatie ophalen...";
            navigator.geolocation.getCurrentPosition(handleGpsSuccess, handleGpsError, {
                enableHighAccuracy: true,
                timeout: 12000,
                maximumAge: 30000
            });
        });

        function setFullscreenUiState(isFullscreen) {
            document.body.classList.toggle("map-fullscreen", isFullscreen);
            mapWrap.classList.toggle("is-fullscreen", isFullscreen);
            if (fullscreenBtn) {
                fullscreenBtn.textContent = isFullscreen ? "Verlaat fullscreen" : "Fullscreen kaart";
            }
        }

        async function enterFullscreen() {
            if (mapWrap.requestFullscreen) {
                await mapWrap.requestFullscreen();
                return;
            }
            fallbackFullscreen = true;
            setFullscreenUiState(true);
        }

        async function leaveFullscreen() {
            if (document.fullscreenElement) {
                await document.exitFullscreen();
                return;
            }
            fallbackFullscreen = false;
            setFullscreenUiState(false);
        }

        fullscreenBtn.addEventListener("click", async () => {
            try {
                const nativeFullscreen = document.fullscreenElement === mapWrap;
                if (nativeFullscreen || fallbackFullscreen) {
                    await leaveFullscreen();
                } else {
                    await enterFullscreen();
                }
            } catch (error) {
                gpsStatus.textContent = "Fullscreen wordt niet ondersteund in deze browser.";
            }
        });

        document.addEventListener("fullscreenchange", () => {
            const isMapFullscreen = document.fullscreenElement === mapWrap;
            fallbackFullscreen = false;
            setFullscreenUiState(isMapFullscreen);
        });

        exitFullscreenBtn.addEventListener("click", async () => {
            try {
                if (document.fullscreenElement || fallbackFullscreen) {
                    await leaveFullscreen();
                }
            } catch (error) {
                gpsStatus.textContent = "Fullscreen afsluiten is niet gelukt.";
            }
        });

        renderMarkers();
    </script>
</body>

</html>