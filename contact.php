<?php
require __DIR__ . '/includes/functions.php';

$title = 'Contact și programare online — Lumea Unghiilor';
$description = 'Programează-te online în câteva secunde. Vezi programul, locația și datele de contact ale salonului Lumea Unghiilor din ⟨Cluj⟩.';
$activ = 'contact';
require __DIR__ . '/includes/header.php';

$status = $_GET['status'] ?? '';
$token = csrf_token();

$prev = $_SESSION['form_prev'] ?? [];
unset($_SESSION['form_prev']);
$prevNume = $prev['nume'] ?? '';
$prevTelefon = $prev['telefon'] ?? '';
$prevServiciu = $prev['serviciu'] ?? '';
$prevData = $prev['data'] ?? '';
$prevOra = $prev['ora'] ?? '';
$prevMesaj = $prev['mesaj'] ?? '';
?>

<section class="page-hero">
  <div class="container">
    <h1>Programează-te în câteva secunde</h1>
    <p>Alege serviciul, ziua și ora. Îți confirmăm rapid programarea.</p>
  </div>
</section>

<section>
  <div class="container cgrid">
    <div>
      <?php if ($status === 'succes'): ?>
        <p class="form-msg form-msg-succes">Mulțumim! Am primit cererea ta. Te contactăm în scurt timp ca să confirmăm ora.</p>
      <?php elseif ($status === 'eroare'): ?>
        <p class="form-msg form-msg-eroare">Ceva nu a mers. Încearcă din nou sau sună-ne direct la ⟨07xx xxx xxx⟩.</p>
      <?php endif; ?>

      <form method="post" action="/trimite-programare" class="form-programare">
        <input type="hidden" name="csrf_token" value="<?= e($token) ?>">
        <div class="hp-field" aria-hidden="true">
          <label for="website">Nu completa acest câmp</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <label for="nume">Nume</label>
        <input id="nume" name="nume" type="text" placeholder="Numele tău" value="<?= e($prevNume) ?>" required>

        <div class="row">
          <div>
            <label for="telefon">Telefon</label>
            <input id="telefon" name="telefon" type="tel" placeholder="07xx xxx xxx" value="<?= e($prevTelefon) ?>" required>
          </div>
          <div>
            <label for="serviciu">Serviciu</label>
            <select id="serviciu" name="serviciu" required>
              <option value="">Alege serviciul</option>
              <?php foreach (SERVICII_VALIDE as $optServiciu): ?>
                <option<?= $prevServiciu === $optServiciu ? ' selected' : '' ?>><?= e($optServiciu) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div>
            <label for="data">Data preferată</label>
            <input id="data" name="data" type="date" value="<?= e($prevData) ?>" required>
          </div>
          <div>
            <label for="ora">Ora preferată</label>
            <input id="ora" name="ora" type="time" value="<?= e($prevOra) ?>" required>
          </div>
        </div>

        <label for="mesaj">Mesaj (opțional)</label>
        <textarea id="mesaj" name="mesaj" rows="3" maxlength="1000" placeholder="Ai o preferință sau o întrebare? Scrie-ne aici."><?= e($prevMesaj) ?></textarea>

        <div class="gdpr">
          <input type="checkbox" id="gdpr" name="gdpr" required>
          <label for="gdpr" style="margin:0">Sunt de acord ca datele mele să fie folosite pentru a-mi confirma programarea. Vezi <a href="/politica-confidentialitate">Politica de confidențialitate</a>.</label>
        </div>

        <button type="submit" class="btn">Trimite programarea</button>
      </form>
    </div>

    <div class="info">
      <div class="card">
        <h3>Contact direct</h3>
        <p><b>Telefon:</b> ⟨07xx xxx xxx⟩<br><b>Email:</b> ⟨contact@lumea-unghiilor.ro⟩</p>
      </div>
      <div class="card">
        <h3>Program</h3>
        <p>⟨Luni–Vineri 09:00–19:00<br>Sâmbătă 09:00–15:00<br>Duminică închis⟩</p>
      </div>
      <div class="card">
        <h3>Adresă</h3>
        <p>⟨Str. Exemplu nr. 10, Cluj-Napoca⟩</p>
        <div class="map">[ Hartă Google Maps ]</div>
      </div>
    </div>
  </div>
</section>

<?php
require __DIR__ . '/includes/footer.php';
