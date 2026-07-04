<?php
http_response_code(404);

$title = 'Pagina nu a fost găsită — Lumea Unghiilor';
$description = 'Pagina căutată nu mai există sau a fost mutată. Întoarce-te la pagina principală Lumea Unghiilor.';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
  <div class="container">
    <h1>Pagina nu a fost găsită</h1>
    <p>Se pare că această pagină nu mai există sau a fost mutată.</p>
    <p style="margin-top:20px"><a href="/" class="btn">Înapoi la pagina principală</a></p>
  </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
