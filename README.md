# 📱 LoveU Festival 2026 - PWA & Offline Handleiding

Welkom bij de officiële handleiding van de **LoveU Festival Progressive Web App (PWA)**! Deze app is volledig geoptimaliseerd om als een native app op mobiele telefoons (Android & iOS) te draaien en werkt **volledig offline** op het festivalterrein.

---

## ✨ PWA functionaliteiten

1. **Volledige Offline Beschikbaarheid:** Zodra je de app één keer online hebt geladen, worden alle pagina's (`index.php`, `lineup.php`, `map.php`, `info.php`) en grafische elementen (SVG-kaart, icoontjes, blokkenschema's) automatisch gecached. Geen internet op het terrein? Geen probleem!
2. **Offline Terrein Kaart & GPS:** De interactieve kaart, locatiemarkers en de GPS-afstandsberekeningen werken 100% offline via de browser van je telefoon.
3. **Meertalige Offline Toegang:** Schakelen tussen Nederlands en Engels werkt direct offline.
4. **Custom Installatiehulp:**
   - **Android:** Een directe, elegante "App Installeren" knop in de app.
   - **iOS:** Een stapsgewijze, visuele handleiding die zich aanpast aan Apple Safari-gebruikers.
5. **Offline QR-Code Deelfunctie:** Deel de app direct met vrienden op het festivalterrein! In de app zit een offline QR-code generator die de huidige URL van de app omzet in een scanbare QR-code.
6. **Online/Offline Status Toast:** Een subtiele neon-toast melding verschijnt bovenaan je scherm wanneer je verbinding wegvalt of herstelt.
7. **Offline Fallback Pagina:** Mocht je een pagina proberen te bezoeken die nog niet in de cache staat terwijl je offline bent, dan zie je een prachtige merk-compatibele offline-pagina.

---

## 📲 Installatie-instructies

### 🤖 Android (Google Chrome / Brave / Edge)
1. Open de website op je telefoon in **Google Chrome**.
2. Je ziet rechtsboven in de balk direct een **Installatie-icoontje** (witte download-pijl) verschijnen. Tik hierop.
3. Er opent een pop-up. Tik op **"Installeren"**.
4. De app staat nu direct op je startscherm tussen je andere apps!

*Werkt de knop niet direct?*
- Tik rechtsboven op de **drie puntjes** in Chrome.
- Selecteer **"App installeren"** of **"Toevoegen aan startscherm"**.

---

### 🍏 iOS / iPhone (Apple Safari)
*Let op: Apple staat installaties alleen toe via de ingebouwde **Safari** browser.*

1. Open de website op je iPhone in **Safari**.
2. Tik rechtsboven op de **Installeren / Delen** knop. Er opent een pop-up met instructies.
3. Tik onderin de navigatiebalk van Safari op de **Deel-knop** (vierkantje met een pijl omhoog: `⎋`).
4. Scroll in het menu naar beneden en tik op **"Zet op beginscherm"** (of **"Add to Home Screen"**).
5. Tik rechtsboven op **"Voeg toe"**.
6. De PWA staat nu op je startscherm met het officiële LoveU Festival logo en start op zonder browserbalken!

---

## 💻 Lokaal testen op je Mobiele Telefoon (via XAMPP)

Progressive Web Apps (PWA) stellen om veiligheidsredenen één strikte eis: ze werken **alleen** via een beveiligde verbinding (**HTTPS**) of op **localhost** (je computer). 

Als je de app op je computer test via `http://localhost/u_festival_app`, werkt de PWA direct. Wil je dit testen op je **mobiele telefoon**, volg dan een van de onderstaande eenvoudige methoden:

### Methode A: Testen via een HTTPS-tunnel met Ngrok (Aanbevolen, duurt 1 minuut)
Met de gratis tool **Ngrok** creëer je in een paar seconden een tijdelijke, beveiligde HTTPS-link die direct toegang geeft tot jouw lokale XAMPP-server.

1. Download en installeer **Ngrok** gratis via [ngrok.com](https://ngrok.com/).
2. Start je XAMPP Apache server.
3. Open je command prompt (CMD / Terminal) op je computer en voer het volgende uit:
   ```bash
   ngrok http 80
   ```
4. Ngrok genereert nu een unieke HTTPS-link (bijvoorbeeld `https://a1b2-34-56-78.ngrok-free.app`).
5. Open deze HTTPS-link op je mobiele telefoon (voeg `/u_festival_app/` toe aan het einde van de link, dus: `https://.../u_festival_app/`).
6. **Klaar!** Je kunt de PWA nu direct installeren en offline testen op je mobiele telefoon. De QR-code in de app zal ook direct deze unieke ngrok-link genereren zodat anderen hem kunnen scannen!

---

### Methode B: Lokaal Wi-Fi netwerk (zonder HTTPS-tunnel)
Als je telefoon en computer op hetzelfde Wi-Fi netwerk zitten, kun je navigeren naar het IP-adres van je computer (bijvoorbeeld `http://192.168.1.15/u_festival_app/`).

*Opmerking:* Omdat dit geen HTTPS-verbinding is, kan het zijn dat Google Chrome op je telefoon de Service Worker weigert. Je kunt dit omzeilen in Chrome op Android:
1. Open Chrome op je telefoon en typ in de adresbalk: `chrome://flags`.
2. Zoek naar **"Insecure origins treated as secure"**.
3. Voer het IP-adres van je computer in (bijv. `http://192.168.1.15`) en zet de instelling op **"Enabled"**.
4. Start Chrome opnieuw op. Nu werkt de PWA ook via je lokale Wi-Fi!

---

## 🛠️ Code-architectuur & Bestanden

Voor de PWA-implementatie zijn de volgende bestanden toegevoegd/aangepast:
- `manifest.json`: Bevat de app-naam, kleuren en koppelingen naar de app-icoontjes.
- `sw.js` (Service Worker): Regelt de slimme offline-caching van statische bestanden (Cache First) en PHP-pagina's (Network First).
- `offline.html`: De prachtige offline-pagina als er geen verbinding is en een pagina niet in de cache staat.
- `pwa-helper.js`: Regelt service worker registratie, offline status toasts en custom installatie-prompts.
- `qrious.min.js`: Offline JavaScript QR-code generator.
- `images/pwa-icon.svg`: Het nieuwe vector app-icoon met het officiële festival-logo en een prachtig verloop.
- `theme-init.php`: Aangepast om centraal de manifest-link en iOS meta-tags in elke `<head>` te injecteren.
- `header.php`: Knop toegevoegd om de installatie/deel modal te openen en de modal-structuur toegevoegd.
- `style.css`: Stijlen toegevoegd voor de modal, tabs, offline toasts en header badges.

Veel festivalplezier met de offline LoveU Festival App! 🎪🎶
