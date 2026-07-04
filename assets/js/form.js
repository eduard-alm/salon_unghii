document.addEventListener('DOMContentLoaded', function () {
  var form = document.querySelector('.form-programare');
  if (!form) {
    return;
  }

  // Confort vizual doar — validarea reală, autoritativă, rămâne pe server (functions.php).
  form.setAttribute('novalidate', 'novalidate');

  var NUME_RE = /^[\p{L}\s-]+$/u;
  var TELEFON_RE = /^0[0-9]{9}$/;

  function normalizeazaTelefon(v) {
    return v.replace(/[\s-]+/g, '');
  }

  var nume = form.querySelector('#nume');
  var telefon = form.querySelector('#telefon');
  var serviciu = form.querySelector('#serviciu');
  var data = form.querySelector('#data');
  var ora = form.querySelector('#ora');
  var gdpr = form.querySelector('#gdpr');

  function setError(field, message) {
    var errEl = document.getElementById('err-' + field.id);
    if (errEl) {
      errEl.textContent = message || '';
    }
    field.classList.toggle('is-invalid', !!message);
    field.setAttribute('aria-invalid', message ? 'true' : 'false');
  }

  function validateNume() {
    var v = nume.value.trim();
    var len = Array.from(v).length;
    if (len < 2 || len > 100 || !NUME_RE.test(v)) {
      setError(nume, 'Introdu un nume valid (doar litere, 2-100 caractere).');
      return false;
    }
    setError(nume, '');
    return true;
  }

  function validateTelefon() {
    if (!TELEFON_RE.test(normalizeazaTelefon(telefon.value.trim()))) {
      setError(telefon, 'Introdu un număr valid, format 07xxxxxxxx.');
      return false;
    }
    setError(telefon, '');
    return true;
  }

  function validateServiciu() {
    if (!serviciu.value) {
      setError(serviciu, 'Alege un serviciu.');
      return false;
    }
    setError(serviciu, '');
    return true;
  }

  function validateData() {
    if (!data.value) {
      setError(data, 'Alege o dată.');
      return false;
    }
    setError(data, '');
    return true;
  }

  function validateOra() {
    if (!ora.value) {
      setError(ora, 'Alege o oră.');
      return false;
    }
    setError(ora, '');
    return true;
  }

  function validateGdpr() {
    if (!gdpr.checked) {
      setError(gdpr, 'Trebuie să fii de acord pentru a trimite programarea.');
      return false;
    }
    setError(gdpr, '');
    return true;
  }

  nume.addEventListener('blur', validateNume);
  telefon.addEventListener('blur', validateTelefon);
  serviciu.addEventListener('blur', validateServiciu);
  serviciu.addEventListener('change', validateServiciu);
  data.addEventListener('blur', validateData);
  data.addEventListener('change', validateData);
  ora.addEventListener('blur', validateOra);
  ora.addEventListener('change', validateOra);
  gdpr.addEventListener('change', validateGdpr);

  form.addEventListener('submit', function (e) {
    var results = [
      validateNume(),
      validateTelefon(),
      validateServiciu(),
      validateData(),
      validateOra(),
      validateGdpr()
    ];

    if (results.indexOf(false) !== -1) {
      e.preventDefault();
      var firstInvalid = form.querySelector('.is-invalid');
      if (firstInvalid) {
        firstInvalid.focus();
      }
    }
  });
});
