function initCookieBanner() {
    const banner = document.getElementById('cookie-banner');
    const acceptButton = document.getElementById('accept-cookies');
    const refuseButton = document.getElementById('refuse-cookies');

    if (!banner) {
        return;
    }

    const consent = localStorage.getItem('cookieConsent');

    // Si un choix a déjà été enregistré,
    // le bandeau reste masqué.
    if (consent === 'accepted' || consent === 'refused') {
        banner.hidden = true;
        return;
    }

    // Accepter les cookies
    acceptButton?.addEventListener('click', () => {
        localStorage.setItem('cookieConsent', 'accepted');
        banner.hidden = true;
    });

    // Refuser les cookies
    refuseButton?.addEventListener('click', () => {
        localStorage.setItem('cookieConsent', 'refused');
        banner.hidden = true;
    });
}

// Chargement classique de la page
document.addEventListener('DOMContentLoaded', initCookieBanner);

// Navigation avec Symfony UX Turbo
document.addEventListener('turbo:load', initCookieBanner);