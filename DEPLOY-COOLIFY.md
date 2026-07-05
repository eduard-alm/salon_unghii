# Deploy pe Coolify — checklist

> Fără valori reale aici — doar NUME de variabile (R20). Valorile se completează
> direct în interfața Coolify, la fiecare pas indicat mai jos.

## 1. Aplicația (build din Git)
1. În Coolify: **New Resource → Application → Public/Private Git Repository**.
2. Alege repo-ul `salon_unghii` (GitHub), branch `main`.
3. **Build Pack:** Dockerfile (Coolify detectează automat `Dockerfile`-ul din rădăcina repo-ului).
4. Port intern container: `80` (Apache, expus deja în `Dockerfile`).
5. Domeniu: fie adresa temporară generată de Coolify (HTTPS automat), fie atașează un domeniu propriu (`.ro`) — Coolify emite automat certificatul Let's Encrypt.

## 2. Baza de date (serviciu separat)
1. În Coolify: **New Resource → Database → MySQL**.
2. Lasă Coolify să genereze host intern / user / parolă (sau setează-le tu — dar nu le scrie nicăieri în cod/vault).
3. Notează undeva sigur (parola manager, NU în vault): host-ul intern al serviciului, numele bazei, user, parolă, port.

## 3. Variabile de mediu pe aplicație
Setează-le în Coolify, pe resursa **Application** (Environment Variables), NU în cod:
- `DB_HOST` — numele/host-ul intern al serviciului MySQL din Coolify (pasul 2)
- `DB_PORT` — implicit `3306` dacă nu suprascrii
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `SMTP_HOST`
- `SMTP_PORT`
- `SMTP_USER`
- `SMTP_PASS`
- `SALON_EMAIL` — adresa unde ajung notificările de programare

## 4. Primul deploy
1. Trigger deploy (push pe `main` sau manual din UI).
2. Verifică log-ul de build/deploy — fără erori fatale la pornirea containerului.
3. După ce aplicația e sus, rulează schema din `sql/programari.sql` pe MySQL-ul din Coolify:
   - Prin terminalul Coolify al serviciului MySQL, SAU
   - Printr-un Adminer/phpMyAdmin conectat la același serviciu.

## 5. Verificări finale (manuale — `[human]`)
- [ ] Aplicația pornește, log fără erori fatale.
- [ ] Site live pe adresa Coolify (HTTPS): cele 5 pagini se încarcă, URL-uri curate merg (`.htaccess`, `AllowOverride All` din `Dockerfile`).
- [ ] O programare reală prin formular → apare în MySQL-ul Coolify + (dacă SMTP e setat corect) email primit la `SALON_EMAIL`.
- [ ] Header `Strict-Transport-Security` prezent pe răspunsul HTTPS (verifică din DevTools sau `curl -I`).

## 6. Repetabilitate
Pentru un al doilea mediu (staging etc.), repetă pașii 1–4 cu un nou set de resurse Coolify (Application + Database) și propriile variabile de mediu — codul (`Dockerfile`, `.htaccess`, `config/config.php`) rămâne neschimbat.
