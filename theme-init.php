<script>
(function () {
    try {
        var t = localStorage.getItem('ufestival-theme');
        document.documentElement.setAttribute('data-theme', t === 'dark' ? 'dark' : 'light');
    } catch (e) {
        document.documentElement.setAttribute('data-theme', 'light');
    }
})();
</script>
<!-- PWA Meta Tags & Manifest Link -->
<link rel="manifest" href="manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="LoveU Fest">
<link rel="apple-touch-icon" href="images/pwa-icon.svg">
<meta name="theme-color" content="#247BA0">

