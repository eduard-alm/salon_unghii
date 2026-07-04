document.addEventListener('DOMContentLoaded', function () {
  var STORAGE_KEY = 'lumea-unghiilor-cookie-consent';
  var banner = document.getElementById('cookie-banner');
  var acceptAllBtn = document.getElementById('cookie-accept-all');
  var acceptNecessareBtn = document.getElementById('cookie-accept-necessare');
  var settingsLink = document.getElementById('cookie-settings-link');

  if (!banner) {
    return;
  }

  function getConsent() {
    try {
      return window.localStorage.getItem(STORAGE_KEY);
    } catch (err) {
      return null;
    }
  }

  function setConsent(value) {
    try {
      window.localStorage.setItem(STORAGE_KEY, value);
    } catch (err) {
      // localStorage indisponibil (mod privat etc.) — bannerul poate reapărea, nu blocăm alegerea.
    }
  }

  function showBanner() {
    banner.hidden = false;
  }

  function hideBanner() {
    banner.hidden = true;
  }

  if (!getConsent()) {
    showBanner();
  }

  if (acceptAllBtn) {
    acceptAllBtn.addEventListener('click', function () {
      setConsent('all');
      hideBanner();
    });
  }

  if (acceptNecessareBtn) {
    acceptNecessareBtn.addEventListener('click', function () {
      setConsent('necessary');
      hideBanner();
    });
  }

  if (settingsLink) {
    settingsLink.addEventListener('click', function (e) {
      e.preventDefault();
      showBanner();
    });
  }
});

// Orice script de analytics adăugat ulterior trebuie să verifice întâi:
// window.localStorage.getItem('lumea-unghiilor-cookie-consent') === 'all'
// și să se încarce DOAR în acel caz (gating GDPR — cerință P05).
