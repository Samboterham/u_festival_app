<div class="header">
    <h1 class="header-tekst">
        <img src="images/logo_white.svg" class="logo-white" alt="">
        <span><span class="brand-accent"></span>U FESTIVAL</span>
    </h1>

    <div class="header-actions">
        <span class="offline-badge" id="offlineBadge" style="display: none;" title="Offline modus actief">Offline</span>
        <button type="button" class="pwa-btn" id="pwaBtn" aria-label="App installeren of delen" style="display: none;">
            <svg class="pwa-icon" viewBox="0 0 24 24" width="23" height="23" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display: block; pointer-events: none;">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
        </button>
        <button type="button" class="theme-toggle-btn" id="themeToggleBtn" aria-label="Schakel donkere modus in">
            <img src="images/night-mode.png" id="themeToggle" class="theme-toggle" alt="" width="25" height="25">
        </button>
        <button type="button" class="language-toggle-btn" id="languageToggleBtn" aria-label="Taal wijzigen">
            <img src="images/dutch.png" id="flagIcon" alt="Nederlands" class="flag-icon">
        </button>
    </div>
</div>
<script>
    const flagIcon = document.getElementById('flagIcon');
    const languageToggleBtn = document.getElementById('languageToggleBtn');

    const translations = {
        nl: {
            htmlLang: 'nl',
            'languageToggle.aria': 'Taal wijzigen',
            'languageToggle.alt': 'Nederlands',
            'welcome.title': 'Welkom bij <span>LoveU Festival</span>',
            'welcome.text': 'Alles wat je nodig hebt op een plek: line-up, terrein map en praktische info. Klaar voor jouw festivaldag?',
            'button.lineup': 'Bekijk Line-up',
            'button.map': 'Open Map',
            'button.info': 'Festival Info',
            'card.lineup.title': 'Line-up',
            'card.lineup.text': 'Bekijk per dag alle stages en tijden in het blokkenschema.',
            'card.map.title': 'Map + GPS',
            'card.map.text': 'Vind podia en faciliteiten snel terug op de interactieve kaart.',
            'card.info.title': 'Handige Info',
            'card.info.text': 'Lees alles over bereikbaarheid, lockers, FAQ en regels.',
            'map.header.title': 'Festival Map',
            'map.header.text': 'Tik op een marker voor info. Gebruik GPS om je afstand tot het festivalterrein te zien.',
            'map.findMeBtn': 'Gebruik mijn GPS locatie',
            'map.fullscreenBtn': 'Fullscreen kaart',
            'map.gpsStatus': 'GPS nog niet geactiveerd.',
            'map.card.title': 'Festival kaart',
            'map.card.text': 'Deze kaart bevat alle locaties en markers direct in het SVG-bestand.',
            'info.header1': 'Algemeen & Contact',
            'info.header2': 'Bereikbaarheid',
            'info.header3': 'Lockers',
            'info.header4': 'FAQ',
            'info.header5': 'Golden-GLU',
            'lineup.subtitle': 'Voorlopig blokkenschema · LoveU Festival 2026 · 10:00 – 23:45',
            'lineup.saturday': 'Zaterdag',
            'lineup.sunday': 'Zondag'
        },
        en: {
            htmlLang: 'en',
            'languageToggle.aria': 'Switch to Dutch',
            'languageToggle.alt': 'English',
            'welcome.title': 'Welcome to <span>LoveU Festival</span>',
            'welcome.text': 'Everything you need in one place: line-up, venue map and practical info. Ready for your festival day?',
            'button.lineup': 'View Line-up',
            'button.map': 'Open Map',
            'button.info': 'Festival Info',
            'card.lineup.title': 'Line-up',
            'card.lineup.text': 'See all stages and times per day in the schedule.',
            'card.map.title': 'Map + GPS',
            'card.map.text': 'Find stages and facilities quickly on the interactive map.',
            'card.info.title': 'Useful Info',
            'card.info.text': 'Read everything about accessibility, lockers, FAQ and rules.',
            'map.header.title': 'Festival Map',
            'map.header.text': 'Tap a marker for info. Use GPS to see your distance to the festival grounds.',
            'map.findMeBtn': 'Use my GPS location',
            'map.fullscreenBtn': 'Fullscreen map',
            'map.gpsStatus': 'GPS not activated yet.',
            'map.card.title': 'Festival map',
            'map.card.text': 'This map contains all locations and markers directly in the SVG file.',
            'info.header1': 'General & Contact',
            'info.header2': 'Accessibility',
            'info.header3': 'Lockers',
            'info.header4': 'FAQ',
            'info.header5': 'Golden-GLU',
            'lineup.subtitle': 'Preliminary schedule · LoveU Festival 2026 · 10:00 – 23:45',
            'lineup.saturday': 'Saturday',
            'lineup.sunday': 'Sunday'
        }
    };

    function translatePage(lang) {
        const dictionary = translations[lang] || translations.nl;
        document.documentElement.lang = dictionary.htmlLang;
        flagIcon.src = lang === 'nl' ? 'images/dutch.png' : 'images/english.png';
        flagIcon.alt = dictionary['languageToggle.alt'];
        languageToggleBtn.setAttribute('aria-label', dictionary['languageToggle.aria']);

        document.querySelectorAll('[data-i18n]').forEach((el) => {
            const key = el.dataset.i18n;
            const value = dictionary[key];
            if (value === undefined) return;
            if (el.dataset.i18nHtml !== undefined) {
                el.innerHTML = value;
            } else {
                el.textContent = value;
            }
        });

        localStorage.setItem('siteLanguage', lang);
    }

    function getStoredLanguage() {
        const stored = localStorage.getItem('siteLanguage');
        return stored === 'en' ? 'en' : 'nl';
    }

    function setLanguage(lang) {
        const nextLang = lang === 'en' ? 'en' : 'nl';
        translatePage(nextLang);
    }

    languageToggleBtn.addEventListener('click', function () {
        const currentLang = flagIcon.src.includes('dutch.png') ? 'nl' : 'en';
        const nextLang = currentLang === 'nl' ? 'en' : 'nl';
        setLanguage(nextLang);
    });

    setLanguage(getStoredLanguage());
</script>
<script src="theme.js"></script>

<!-- PWA & QR-Code Modal -->
<div id="pwaModal" class="pwa-modal hidden" role="dialog" aria-modal="true" aria-labelledby="pwaModalTitle">
    <div class="pwa-modal-content">
        <div class="pwa-modal-header">
            <h2 id="pwaModalTitle" class="pwa-modal-title">Installeer LoveU Fest</h2>
            <button type="button" class="close-pwa-modal" id="closePwaModal" aria-label="Sluit modal">&times;</button>
        </div>
        
        <!-- Modal Tabs -->
        <div class="pwa-modal-tabs">
            <button type="button" class="pwa-tab-btn active" id="installTabBtn">Installeren</button>
            <button type="button" class="pwa-tab-btn" id="qrTabBtn">Delen</button>
        </div>

        <!-- Install App Section -->
        <div class="pwa-section" id="pwaInstallSection">
            <div class="pwa-app-card">
                <img src="images/pwa-icon.svg" class="pwa-app-logo" alt="LoveU Logo">
                <div class="pwa-app-info">
                    <h3 id="pwaInstallTitle">LoveU Festival 2026</h3>
                    <p>U Festival Team</p>
                </div>
            </div>
            <p class="pwa-desc" id="pwaInstallDesc">Installeer deze app op je startscherm voor snelle toegang en volledige offline beschikbaarheid tijdens het festival!</p>
            <button type="button" class="pwa-primary-btn" id="doInstallBtn">App Installeren</button>
        </div>

        <!-- Share App / QR Section -->
        <div class="pwa-section" id="pwaQrSection" style="display: none;">
            <h3 id="pwaQrTitle" style="margin-top: 0; font-size: 1.15rem; color: var(--color-brand);">Deel via QR-Code</h3>
            <p class="pwa-desc" id="pwaQrDesc">Laat je vrienden deze QR-code scannen om het LoveU Festival direct op hun telefoon te openen en te installeren!</p>
            <div class="pwa-qr-container">
                <canvas id="pwaQrCanvas"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="qrious.min.js"></script>
<script src="pwa-helper.js"></script>
