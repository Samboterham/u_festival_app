<?php
$assetBase = 'C:\\Users\\bergh\\.cursor\\projects\\c-xampp-htdocs-u-festivall-app\\assets\\';
$assets = [
    'festival-map' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_kaart_festival_no_markers-19c2f88a-4c08-402f-8723-1ff6a2cae976.png',
    'marker-first-aid' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_first_aid-b41f4fa8-28a1-4a20-874c-916fa5b42cde.png',
    'marker-entrance' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_entrance_exit-1f93a5d7-8f8d-4d8d-810c-d21ca6db3942.png',
    'marker-ice-cream' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_ice_cream-0fc83c2c-d5d7-48ec-bf34-09f982f870af.png',
    'marker-merch' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_merchandise-a4bd9411-f53d-4322-8cf4-3df4463f9e54.png',
    'marker-bar' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_bar-0d16ee47-5702-4999-b2cf-c5bab8ef6a12.png',
    'marker-food' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_food-f73717ec-b9e6-48e9-afa8-58900f02f549.png',
    'marker-stage-1' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_stage1_ponton-ad18e49e-e79e-49c1-90b3-947f11b824d3.png',
    'marker-stage-2' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_stage2_the_lake-8dcae0c1-87cf-4314-831e-7dc49c4a8f84.png',
    'marker-stage-3' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_stage3_the_club-2acc4e74-b210-4a6f-980a-a1457a0290a3.png',
    'marker-stage-4' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_stage4_hangar-db787cb6-61d8-4f13-8673-42ad81a6eee3.png',
    'marker-locker' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_locker-aabfc9e0-b8eb-4964-9cb6-a6d98979ac2c.png',
    'marker-toilet' => $assetBase . 'c__Users_bergh_AppData_Roaming_Cursor_User_workspaceStorage_02d638f7655a4f22f98408757b61d129_images_marker_toilet-d43653f0-a096-4676-927d-7bed6965dbc0.png',
];

if (isset($_GET['asset']) && isset($assets[$_GET['asset']])) {
    $assetPath = $assets[$_GET['asset']];
    if (!file_exists($assetPath)) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Asset not found.';
        exit;
    }

    header('Content-Type: image/png');
    header('Cache-Control: public, max-age=86400');
    readfile($assetPath);
    exit;
}
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
            aspect-ratio: 159 / 283;
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
            width: 177.99vh;
            max-width: none;
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
            width: 38px;
            height: 38px;
            border: none;
            background: transparent;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.28);
            transition: transform 0.2s ease, filter 0.2s ease;
            padding: 0;
            z-index: 4;
        }

        .map-marker.small {
            width: 30px;
            height: 30px;
        }

        .map-marker:hover,
        .map-marker.active {
            transform: translate(-50%, -50%) scale(1.08);
            filter: brightness(1.08);
        }

        .map-marker img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: contain;
            pointer-events: none;
        }

        .map-marker.entrance {
            width: 108px;
            height: 34px;
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
            <img class="festival-map-image" src="map.php?asset=festival-map" alt="Festival terrein kaart">
        </div>

        <section class="map-info-card" id="infoCard" aria-live="polite">
            <h2>Kies een marker</h2>
            <p>Klik op een punt op de kaart om locatie-info te zien.</p>
        </section>
    </main>

    <footer>
        <?php include 'footer.php' ?>
    </footer>

    <script>
        const festivalLat = 52.0767408;
        const festivalLon = 5.1046989;

        const markerIconUrl = {
            stage1: "map.php?asset=marker-stage-1",
            stage2: "map.php?asset=marker-stage-2",
            stage3: "map.php?asset=marker-stage-3",
            stage4: "map.php?asset=marker-stage-4",
            entrance: "map.php?asset=marker-entrance",
            firstAid: "map.php?asset=marker-first-aid",
            food: "map.php?asset=marker-food",
            bar: "map.php?asset=marker-bar",
            iceCream: "map.php?asset=marker-ice-cream",
            merch: "map.php?asset=marker-merch",
            locker: "map.php?asset=marker-locker",
            toilet: "map.php?asset=marker-toilet"
        };

        const locations = [
            { id: "stage1", name: "Stage 1 - Ponton", description: "Mainstage voor de grootste artiesten.", tips: "Kom vroeg voor de headliners.", icon: "stage1", size: "normal" },
            { id: "stage2", name: "Stage 2 - The Lake", description: "Talent stage aan het water.", tips: "Top plek om nieuwe acts te ontdekken.", icon: "stage2", size: "normal" },
            { id: "stage3", name: "Stage 3 - The Club", description: "Club area met dance en specials.", tips: "Hier is het vaak druk in de avond.", icon: "stage3", size: "normal" },
            { id: "stage4", name: "Stage 4 - Hangar", description: "Hangar met DJ sets en live shows.", tips: "Perfect voor late-night vibes.", icon: "stage4", size: "normal" },
            { id: "entrance", name: "Entrance / Exit", description: "Ingang en uitgang van het terrein.", tips: "Gebruik deze zone ook als meetpoint.", icon: "entrance", size: "entrance" },
            { id: "firstAid", name: "EHBO", description: "Eerste hulp post op het terrein.", tips: "Bij klachten direct melden bij de EHBO.", icon: "firstAid", size: "small" },
            { id: "food", name: "Food", description: "Food area met meerdere stands.", tips: "Rond piekuren kan het hier druk zijn.", icon: "food", size: "small" },
            { id: "bar", name: "Bar", description: "Drankpunten verspreid over het terrein.", tips: "Houd je ID paraat bij bestelling.", icon: "bar", size: "small" },
            { id: "iceCream", name: "Ice Cream", description: "IJsverkoop op het terrein.", tips: "Populair bij warm weer.", icon: "iceCream", size: "small" },
            { id: "merch", name: "Merchandise", description: "Officiele festival merchandise.", tips: "Beperkte voorraad op populaire items.", icon: "merch", size: "small" },
            { id: "locker", name: "Lockers", description: "Opbergkluizen voor persoonlijke spullen.", tips: "Neem een powerbank mee voor lange dag.", icon: "locker", size: "small" },
            { id: "toilet", name: "Toilet", description: "Sanitaire voorzieningen.", tips: "Er zijn meerdere toiletpunten op het terrein.", icon: "toilet", size: "small" }
        ];

        // Approximate positions on the original landscape map (x/y in percentages)
        const markerPositions = {
            stage1: { x: 18, y: 64 },
            stage2: { x: 57, y: 56 },
            stage3: { x: 68, y: 53 },
            stage4: { x: 82, y: 17 },
            entrance: { x: 82, y: 8 },
            firstAid: { x: 12, y: 24 },
            food: { x: 42, y: 47 },
            bar: { x: 35, y: 45 },
            iceCream: { x: 50, y: 54 },
            merch: { x: 44, y: 58 },
            locker: { x: 60, y: 48 },
            toilet: { x: 54, y: 42 }
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
                <h2>${location.id}. ${location.name}</h2>
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
                if (location.size === "entrance") {
                    marker.classList.add("entrance");
                } else if (location.size === "small") {
                    marker.classList.add("small");
                }
                marker.innerHTML = `<img src="${markerIconUrl[location.icon]}" alt="">`;
                marker.setAttribute("aria-label", `${location.name} info`);

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