</main>
<footer class="site-footer">
  <div class="container">
    <div class="fgrid">
      <div>
        <div class="logo" style="color:#fff">Lumea Unghiilor</div>
        <p style="font-size:14px;margin-top:10px;color:#f0cdd2">Salon de unghii în ⟨Cluj-Napoca⟩.</p>
      </div>
      <div>
        <h4>Salon</h4>
        <a href="/servicii">Servicii</a>
        <a href="/galerie">Galerie</a>
        <a href="/despre">Despre noi</a>
      </div>
      <div>
        <h4>Contact</h4>
        <a href="tel:⟨07xxxxxxxx⟩">⟨07xx xxx xxx⟩</a>
        <a href="#">⟨Str. Exemplu 10⟩</a>
        <a href="#">L–V 09–19</a>
      </div>
      <div>
        <h4>Legal</h4>
        <a href="/politica-confidentialitate">Confidențialitate</a>
        <a href="#" id="cookie-settings-link">Cookies</a>
        <a href="#">Instagram</a>
      </div>
    </div>
    <div class="copyright">&copy; <span id="footer-year"></span> Lumea Unghiilor. Toate drepturile rezervate. · Realizat de FastCoding Agency</div>
  </div>
</footer>

<div class="cookie-banner" id="cookie-banner" hidden>
  <p>Folosim cookie-uri pentru a-ți oferi cea mai bună experiență pe site.</p>
  <div class="actions">
    <button type="button" class="btn-sec btn" id="cookie-accept-necessare">Doar necesare</button>
    <button type="button" class="btn" id="cookie-accept-all">Accept</button>
  </div>
</div>

<script src="/assets/js/main.js"></script>
<?php if (($activ ?? '') === 'galerie'): ?>
<script src="/assets/js/gallery.js"></script>
<?php endif; ?>
<?php if (($activ ?? '') === 'contact'): ?>
<script src="/assets/js/form.js"></script>
<?php endif; ?>
</body>
</html>
