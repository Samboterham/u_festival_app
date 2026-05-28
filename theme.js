(function () {
    const STORAGE_KEY = 'ufestival-theme';
    const ICON_TO_DARK = 'images/night-mode.png';
    const ICON_TO_LIGHT = 'images/light.png';

    function getTheme() {
        return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    }

    function updateToggleIcon(theme) {
        const icon = document.getElementById('themeToggle');
        const btn = document.getElementById('themeToggleBtn');
        if (!icon) return;
        if (theme === 'dark') {
            icon.src = ICON_TO_LIGHT;
            icon.alt = '';
            if (btn) btn.setAttribute('aria-label', 'Schakel naar lichte modus');
        } else {
            icon.src = ICON_TO_DARK;
            icon.alt = '';
            if (btn) btn.setAttribute('aria-label', 'Schakel naar donkere modus');
        }
    }

    function setTheme(theme) {
        const next = theme === 'dark' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', next);
        try {
            localStorage.setItem(STORAGE_KEY, next);
        } catch (e) { /* ignore */ }
        updateToggleIcon(next);
    }

    function toggleTheme() {
        setTheme(getTheme() === 'dark' ? 'light' : 'dark');
    }

    function init() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved === 'dark' || saved === 'light') {
                document.documentElement.setAttribute('data-theme', saved);
            }
        } catch (e) { /* ignore */ }
        updateToggleIcon(getTheme());

        const btn = document.getElementById('themeToggleBtn');
        if (!btn) return;

        btn.addEventListener('click', toggleTheme);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
