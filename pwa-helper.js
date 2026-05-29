/**
 * PWA Helper - LoveU Festival 2026
 * Beheert Service Worker registratie, custom installatie-prompts (Android & iOS),
 * offline/online status-toasts en dynamische QR-code generatie.
 */

(function () {
    // 1. REGISTREER SERVICE WORKER
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js')
                .then(reg => {
                    console.log('[PWA] Service Worker geregistreerd met scope:', reg.scope);
                })
                .catch(err => {
                    console.error('[PWA] Service Worker registratie mislukt:', err);
                });
        });
    }

    // PWA Variabelen
    let deferredPrompt;
    const pwaBtn = document.getElementById('pwaBtn');
    const pwaModal = document.getElementById('pwaModal');
    const closePwaModal = document.getElementById('closePwaModal');
    const installTabBtn = document.getElementById('installTabBtn');
    const qrTabBtn = document.getElementById('qrTabBtn');
    const installSection = document.getElementById('pwaInstallSection');
    const qrSection = document.getElementById('pwaQrSection');
    const qrCanvas = document.getElementById('pwaQrCanvas');
    const doInstallBtn = document.getElementById('doInstallBtn');

    // Browser- en platformdetectie
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

    // Vertalingen voor PWA-elementen
    const pwaTranslations = {
        nl: {
            toastOffline: '⚠️ Je bent nu offline. Offline modus actief.',
            toastOnline: '⚡ Je bent weer online! Gegevens worden bijgewerkt.',
            installTitle: 'Installeer LoveU Fest',
            installDescAndroid: 'Installeer deze app op je startscherm voor snelle toegang en volledige offline beschikbaarheid tijdens het festival!',
            installDescIOS: 'Voeg LoveU Fest toe aan je startscherm! Tik onderaan op het deel-icoontje <strong class="share-icon-placeholder">⎋</strong> en selecteer vervolgens <strong>"Zet op beginscherm"</strong>.',
            installBtn: 'App Installeren',
            shareTitle: 'Deel via QR-Code',
            shareDesc: 'Laat je vrienden deze QR-code scannen om het LoveU Festival direct op hun telefoon te openen en te installeren!'
        },
        en: {
            toastOffline: '⚠️ You are now offline. Offline mode active.',
            toastOnline: '⚡ You are back online! Data is being updated.',
            installTitle: 'Install LoveU Fest',
            installDescAndroid: 'Install this app on your home screen for quick access and full offline availability during the festival!',
            installDescIOS: 'Add LoveU Fest to your home screen! Tap the share button <strong class="share-icon-placeholder">⎋</strong> at the bottom, then select <strong>"Add to Home Screen"</strong>.',
            installBtn: 'Install App',
            shareTitle: 'Share via QR-Code',
            shareDesc: 'Let your friends scan this QR code to instantly open and install LoveU Festival on their phone!'
        }
    };

    function getPwaTranslation(key) {
        const lang = localStorage.getItem('siteLanguage') === 'en' ? 'en' : 'nl';
        return pwaTranslations[lang][key] || '';
    }

    // Toon PWA knop als installatie mogelijk is of we op iOS (niet-standalone) zijn
    function initPwaUi() {
        if (!pwaBtn) return;

        // Als we al in de geïnstalleerde standalone modus zitten, tonen we de knop alleen voor "Delen via QR"
        if (isStandalone) {
            pwaBtn.style.display = 'flex';
            pwaBtn.setAttribute('aria-label', 'Deel app via QR-code');
            
            // Verberg de installatietab in de modal en open direct de QR sectie
            if (installTabBtn) installTabBtn.style.display = 'none';
            if (qrTabBtn) qrTabBtn.classList.add('active');
            if (installSection) installSection.style.display = 'none';
            if (qrSection) qrSection.style.display = 'block';
        } 
        // Als het Android/Chrome is (deferredPrompt aanwezig) of iOS (Safari, nog niet geïnstalleerd)
        else if (deferredPrompt || isIOS) {
            pwaBtn.style.display = 'flex';
            pwaBtn.setAttribute('aria-label', 'Installeer of deel de app');
            
            // Toon de installatietab en zet deze als actief
            if (installTabBtn) {
                installTabBtn.style.display = 'inline-block';
                installTabBtn.classList.add('active');
            }
            if (qrTabBtn) qrTabBtn.classList.remove('active');
            if (installSection) installSection.style.display = 'block';
            if (qrSection) qrSection.style.display = 'none';

            // Pas instructie aan op basis van platform (Android vs iOS)
            const installDesc = document.getElementById('pwaInstallDesc');
            if (installDesc) {
                if (isIOS) {
                    installDesc.innerHTML = getPwaTranslation('installDescIOS');
                    if (doInstallBtn) doInstallBtn.style.display = 'none'; // Verberg knop op iOS (moet via Safari UI)
                } else {
                    installDesc.textContent = getPwaTranslation('installDescAndroid');
                    if (doInstallBtn) doInstallBtn.style.display = 'block';
                }
            }
        }
    }

    // 2. DETECTEER BROWSER INSTALLATION PROMPT (Android/Chrome)
    window.addEventListener('beforeinstallprompt', (e) => {
        // Voorkom de standaard browser prompt
        e.preventDefault();
        // Sla het event op
        deferredPrompt = e;
        // Initialiseer de UI knop
        initPwaUi();
    });

    // Luister ook naar succesvolle installatie
    window.addEventListener('appinstalled', (evt) => {
        console.log('[PWA] App is succesvol geïnstalleerd!');
        deferredPrompt = null;
        initPwaUi(); // Update UI
        
        // Optioneel: verberg de installatie modal als deze open was
        if (pwaModal) pwaModal.classList.add('hidden');
    });

    // Init UI op load (voor iOS detectie of al standalone modus)
    initPwaUi();

    // 3. MODAL LOGICA (OPENEN / SLUITEN / TABS)
    if (pwaBtn) {
        pwaBtn.addEventListener('click', () => {
            if (!pwaModal) return;
            
            // Dynamisch titels vertalen bij openen
            const modalTitle = pwaModal.querySelector('.pwa-modal-title');
            if (modalTitle) {
                modalTitle.textContent = isStandalone ? getPwaTranslation('shareTitle') : getPwaTranslation('installTitle');
            }
            
            const installTitle = document.getElementById('pwaInstallTitle');
            if (installTitle) installTitle.textContent = getPwaTranslation('installTitle');
            
            const installBtnText = document.getElementById('doInstallBtn');
            if (installBtnText) installBtnText.textContent = getPwaTranslation('installBtn');
            
            const qrTitle = document.getElementById('pwaQrTitle');
            if (qrTitle) qrTitle.textContent = getPwaTranslation('shareTitle');
            
            const qrDesc = document.getElementById('pwaQrDesc');
            if (qrDesc) qrDesc.textContent = getPwaTranslation('shareDesc');

            const installDesc = document.getElementById('pwaInstallDesc');
            if (installDesc && isIOS) {
                installDesc.innerHTML = getPwaTranslation('installDescIOS');
            } else if (installDesc) {
                installDesc.textContent = getPwaTranslation('installDescAndroid');
            }

            pwaModal.classList.remove('hidden');

            // 4. DYNAMISCHE QR CODE GENERATIE (Offline met QRious)
            if (qrCanvas && typeof QRious !== 'undefined') {
                // Haal de huidige pagina URL op
                const currentUrl = window.location.origin + window.location.pathname;
                
                new QRious({
                    element: qrCanvas,
                    value: currentUrl,
                    size: 200,
                    background: 'white',
                    foreground: '#247BA0', // Cerulean Blue brand kleur
                    level: 'H' // High error correction
                });
            }
        });
    }

    if (closePwaModal) {
        closePwaModal.addEventListener('click', () => {
            if (pwaModal) pwaModal.classList.add('hidden');
        });
    }

    // Klik buiten de modal om te sluiten
    window.addEventListener('click', (event) => {
        if (pwaModal && event.target === pwaModal) {
            pwaModal.classList.add('hidden');
        }
    });

    // Tabbed interface logica
    if (installTabBtn && qrTabBtn) {
        installTabBtn.addEventListener('click', () => {
            installTabBtn.classList.add('active');
            qrTabBtn.classList.remove('active');
            if (installSection) installSection.style.display = 'block';
            if (qrSection) qrSection.style.display = 'none';
        });

        qrTabBtn.addEventListener('click', () => {
            qrTabBtn.classList.add('active');
            installTabBtn.classList.remove('active');
            if (installSection) installSection.style.display = 'none';
            if (qrSection) qrSection.style.display = 'block';
        });
    }

    // Trigger de installatie via onze knop (Android)
    if (doInstallBtn) {
        doInstallBtn.addEventListener('click', async () => {
            if (!deferredPrompt) return;
            
            // Toon de native prompt
            deferredPrompt.prompt();
            
            // Wacht op de keuze van de gebruiker
            const { outcome } = await deferredPrompt.userChoice;
            console.log(`[PWA] Gebruiker installatie keuze: ${outcome}`);
            
            // We hebben het event verbruikt, leegmaken
            deferredPrompt = null;
            initPwaUi(); // Update UI
            
            if (pwaModal) pwaModal.classList.add('hidden');
        });
    }

    // 5. OFFLINE / ONLINE DETECTIE (TOAST NOTIFICATIE + BADGE)
    const toast = document.createElement('div');
    toast.className = 'pwa-toast hidden';
    document.body.appendChild(toast);

    function showToast(message, isOffline = false) {
        toast.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.toggle('offline', isOffline);
        toast.classList.add('show');

        // Voor online meldingen, verberg de toast na 3.5 seconden
        if (!isOffline) {
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 3500);
        }
    }

    function updateOnlineStatus() {
        const isOnline = navigator.onLine;
        const offlineBadge = document.getElementById('offlineBadge');

        if (isOnline) {
            // Verberg de offline badge in de header
            if (offlineBadge) offlineBadge.style.display = 'none';
            
            // Toon "Weer online" toast (enkel als we eerder offline waren)
            if (document.body.classList.contains('is-offline')) {
                document.body.classList.remove('is-offline');
                showToast(getPwaTranslation('toastOnline'), false);
            }
        } else {
            // Toon de offline badge in de header
            if (offlineBadge) offlineBadge.style.display = 'inline-flex';
            
            // Toon "Je bent nu offline" toast
            document.body.classList.add('is-offline');
            showToast(getPwaTranslation('toastOffline'), true);
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    
    // Voer initiële check uit
    updateOnlineStatus();

    // Event listener voor taalwijziging om modal dynamisch bij te werken
    const languageBtn = document.getElementById('languageToggleBtn');
    if (languageBtn) {
        languageBtn.addEventListener('click', () => {
            // Korte delay zodat localStorage bijgewerkt is
            setTimeout(() => {
                initPwaUi();
            }, 100);
        });
    }
})();
