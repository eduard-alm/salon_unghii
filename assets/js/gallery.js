document.addEventListener('DOMContentLoaded', function () {
  var allImages = Array.prototype.slice.call(document.querySelectorAll('[data-lightbox]'));
  if (!allImages.length) {
    return;
  }

  var chips = Array.prototype.slice.call(document.querySelectorAll('.chip[data-filter]'));

  function visibleImages() {
    return allImages.filter(function (img) {
      return !img.classList.contains('is-hidden');
    });
  }

  function applyFilter(filter) {
    allImages.forEach(function (img) {
      var match = filter === 'toate' || img.getAttribute('data-category') === filter;
      img.classList.toggle('is-hidden', !match);
    });
  }

  chips.forEach(function (chip) {
    chip.setAttribute('aria-pressed', chip.classList.contains('active') ? 'true' : 'false');
    chip.addEventListener('click', function () {
      chips.forEach(function (c) {
        c.classList.remove('active');
        c.setAttribute('aria-pressed', 'false');
      });
      chip.classList.add('active');
      chip.setAttribute('aria-pressed', 'true');
      applyFilter(chip.getAttribute('data-filter'));
    });
  });

  var images = visibleImages();

  var overlay = document.createElement('div');
  overlay.className = 'lightbox-overlay';
  overlay.setAttribute('role', 'dialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-label', 'Imagine mărită din galerie');
  overlay.hidden = true;
  overlay.innerHTML =
    '<button type="button" class="lightbox-close" aria-label="Închide">&#10005;</button>' +
    '<button type="button" class="lightbox-prev" aria-label="Imaginea anterioară">&#8249;</button>' +
    '<img class="lightbox-img" src="" alt="">' +
    '<button type="button" class="lightbox-next" aria-label="Imaginea următoare">&#8250;</button>';
  document.body.appendChild(overlay);

  var imgEl = overlay.querySelector('.lightbox-img');
  var closeBtn = overlay.querySelector('.lightbox-close');
  var prevBtn = overlay.querySelector('.lightbox-prev');
  var nextBtn = overlay.querySelector('.lightbox-next');
  var focusable = [closeBtn, prevBtn, nextBtn];
  var currentIndex = 0;
  var lastFocused = null;

  function show(index) {
    currentIndex = (index + images.length) % images.length;
    imgEl.src = images[currentIndex].getAttribute('src');
    imgEl.alt = images[currentIndex].getAttribute('alt') || '';
  }

  function onKeydown(e) {
    if (e.key === 'Escape') {
      close();
    } else if (e.key === 'ArrowLeft') {
      show(currentIndex - 1);
    } else if (e.key === 'ArrowRight') {
      show(currentIndex + 1);
    } else if (e.key === 'Tab') {
      var idx = focusable.indexOf(document.activeElement);
      e.preventDefault();
      idx = e.shiftKey
        ? (idx - 1 + focusable.length) % focusable.length
        : (idx + 1) % focusable.length;
      focusable[idx].focus();
    }
  }

  function open(img) {
    images = visibleImages();
    var index = images.indexOf(img);
    if (index === -1) {
      index = 0;
    }
    lastFocused = document.activeElement;
    show(index);
    overlay.hidden = false;
    closeBtn.focus();
    document.addEventListener('keydown', onKeydown);
  }

  function close() {
    overlay.hidden = true;
    document.removeEventListener('keydown', onKeydown);
    if (lastFocused && typeof lastFocused.focus === 'function') {
      lastFocused.focus();
    }
  }

  allImages.forEach(function (img) {
    img.setAttribute('tabindex', '0');
    img.setAttribute('role', 'button');
    img.addEventListener('click', function () {
      open(img);
    });
    img.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        open(img);
      }
    });
  });

  closeBtn.addEventListener('click', close);
  prevBtn.addEventListener('click', function () { show(currentIndex - 1); });
  nextBtn.addEventListener('click', function () { show(currentIndex + 1); });
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      close();
    }
  });
});
