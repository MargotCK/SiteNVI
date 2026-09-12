document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('cookie-banner');
    const acceptButton = document.getElementById('accept-cookies');
    const refuseButton = document.getElementById('refuse-cookies');

    if (!banner) {
        return;
    }

    const consent = localStorage.getItem('cookieConsent');

    if (consent === 'accepted' || consent === 'refused') {
        banner.hidden = true;
    }

    acceptButton?.addEventListener('click', () => {
        localStorage.setItem('cookieConsent', 'accepted');
        banner.hidden = true;
    });

    refuseButton?.addEventListener('click', () => {
        localStorage.setItem('cookieConsent', 'refused');
        banner.hidden = true;
    });
});