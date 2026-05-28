<div class="header">
    <h1 class="header-tekst">
        <img src="images/logo_white.svg" class="logo-white" alt="">
        <span><span class="brand-accent"></span>U FESTIVAL</span>
    </h1>

    <div class="header-actions">
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

    languageToggleBtn.addEventListener('click', function () {
        if (flagIcon.src.includes('dutch.png')) {
            flagIcon.src = 'images/english.png';
            flagIcon.alt = 'English';
            languageToggleBtn.setAttribute('aria-label', 'Switch to Dutch');
        } else {
            flagIcon.src = 'images/dutch.png';
            flagIcon.alt = 'Nederlands';
            languageToggleBtn.setAttribute('aria-label', 'Taal wijzigen');
        }
    });
</script>
<script src="theme.js"></script>
