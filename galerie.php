<?php
$title = 'Galerie lucrări — Lumea Unghiilor';
$description = 'Modele reale realizate în salonul nostru: manichiură, nail art, culori de sezon. Inspiră-te și programează-te.';
$activ = 'galerie';
require __DIR__ . '/includes/header.php';

$altTexts = [
    'Manichiură semipermanentă nude cu accent auriu',
    'Construcție unghii cu model french modern',
    'Nail art floral pe fundal roz pastel',
    'Pedichiură semipermanentă roșu clasic',
];

$categorii = ['manichiura', 'constructie', 'nailart', 'pedichiura'];
?>

<section class="page-hero">
  <div class="container">
    <h1>Lucrări reale, făcute la noi în salon</h1>
    <p>Fără poze de stoc. Fiecare model de aici a fost făcut pentru o clientă adevărată.</p>
  </div>
</section>

<section>
  <div class="container">
    <div class="filters">
      <button type="button" class="chip active" data-filter="toate">Toate</button>
      <button type="button" class="chip" data-filter="manichiura">Manichiură</button>
      <button type="button" class="chip" data-filter="constructie">Construcție</button>
      <button type="button" class="chip" data-filter="pedichiura">Pedichiură</button>
      <button type="button" class="chip" data-filter="nailart">Nail art</button>
    </div>
    <div class="gal">
      <?php for ($i = 0; $i < 12; $i++): ?>
        <img src="/assets/images/placeholder-galerie.svg" alt="<?= e($altTexts[$i % count($altTexts)]) ?>" loading="lazy" data-lightbox data-category="<?= e($categorii[$i % count($categorii)]) ?>">
      <?php endfor; ?>
    </div>
  </div>
</section>

<section class="ctaband">
  <div class="container">
    <h2>Ți-a plăcut un model?</h2>
    <p>Îl putem face și pentru tine.</p>
    <a href="/contact" class="btn">Programează-te</a>
  </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
