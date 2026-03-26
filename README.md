<p align="center">
  <img src="public/images/logo/logo-icon.svg" width="64" height="64" alt="BudgetKit logo" />
</p>

<h1 align="center">BudgetKit</h1>

<p align="center">
  <strong>Tieni il controllo delle tue finanze.</strong><br/>
  Personal finance manager open source — built with Laravel & Tailwind CSS.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red?logo=laravel" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4-38bdf8?logo=tailwindcss" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/license-MIT-green" alt="MIT License" />
</p>

---

## Cos'è BudgetKit

BudgetKit è un'applicazione web per la gestione delle finanze personali. Permette di tracciare entrate e uscite, impostare un budget mensile per categoria, monitorare obiettivi di risparmio e visualizzare statistiche di spesa — il tutto con un'interfaccia pulita, dark mode inclusa.

Il layout si adatta automaticamente al dispositivo: **interfaccia desktop** con sidebar e tabelle, **interfaccia mobile** con gradient UI e navigazione bottom tab — senza app da installare.

---

## Screenshots

<table>
  <tr>
    <td align="center"><b>Desktop</b></td>
    <td align="center"><b>Mobile</b></td>
  </tr>
  <tr>
    <td><img src=".github/screenshots/desktop.png" alt="BudgetKit desktop" /></td>
    <td><img src=".github/screenshots/mobile.png" alt="BudgetKit mobile" /></td>
  </tr>
</table>

---

## Funzionalità

- **Dashboard** — panoramica immediata: saldo disponibile, totale assegnato, obiettivi attivi
- **Transazioni** — registra entrate e uscite, filtra per tipo e mese
- **Budget** — assegna un budget mensile per ogni categoria, copia il budget del mese precedente
- **Obiettivi** — crea obiettivi di risparmio con importo target e progresso visivo
- **Statistiche** — grafico donut per categoria + trend mensile entrate/uscite (6 mesi)
- **Categorie** — gestisci categorie personalizzate con emoji e colore
- **Impostazioni** — lingua (IT/EN) e valuta (EUR, USD, GBP, CHF)
- **Export CSV** — esporta tutte le transazioni
- **Auth** — registrazione e login, profilo con modifica nome/email/password
- **Dark mode** — supporto nativo
- **Multi-lingua** — italiano e inglese
- **Responsive automatico** — layout desktop con sidebar su PC, layout mobile ottimizzato su smartphone (rilevamento User-Agent)

---

## Stack tecnologico

| Layer | Tecnologia |
|---|---|
| Backend | Laravel 12 |
| Frontend | Tailwind CSS v4, Alpine.js |
| Charts | ApexCharts |
| Template base | TailAdmin Laravel |
| Database | SQLite / MySQL / PostgreSQL |

---

## Installazione

### Requisiti
- PHP 8.2+
- Composer
- Node.js 18+

### Setup

```bash
# 1. Clona il repository
git clone https://github.com/tuo-username/budgetkit.git
cd budgetkit

# 2. Installa dipendenze PHP
composer install

# 3. Installa dipendenze JS
npm install

# 4. Configura l'ambiente
cp .env.example .env
php artisan key:generate

# 5. Configura il database in .env, poi esegui le migration
php artisan migrate

# 6. Build assets
npm run build

# 7. Avvia il server
php artisan serve
```

Apri `http://localhost:8000`, registra un account e inizia a usare BudgetKit.

### Sviluppo con hot reload

```bash
npm run dev
php artisan serve
```

---

## Struttura del progetto

```
app/
├── Http/Controllers/       # Controller per ogni modulo
│   └── Auth/               # Login, Register
├── Http/Requests/          # Form request validation
├── Models/                 # Eloquent models
├── Services/               # BudgetService — logica di business
└── Helpers/                # MenuHelper — sidebar navigation

lang/
├── it/ui.php               # Traduzioni italiano
└── en/ui.php               # Traduzioni inglese

resources/views/
├── layouts/                # app.blade.php (desktop), mobile.blade.php (mobile), sidebar, header
├── mobile/                 # Viste ottimizzate per smartphone (gradient UI, bottom nav)
├── home/                   # Dashboard
├── transactions/           # Lista + form transazioni
├── budget/                 # Budget mensile
├── goals/                  # Obiettivi
├── stats/                  # Statistiche
├── categories/             # Categorie
├── settings/               # Impostazioni
├── profile/                # Profilo utente
└── auth/                   # Login + Register
```

---

## Configurazione

Le impostazioni principali si trovano in `config/budget.php`:

```php
'locales'          => ['it', 'en'],
'default_locale'   => 'it',
'currencies'       => ['EUR', 'USD', 'GBP', 'CHF'],
'default_currency' => 'EUR',
```

---

## Contribuire

Pull request benvenute. Per cambiamenti importanti, apri prima una issue per discutere cosa vorresti modificare.

1. Fork del repository
2. Crea un branch (`git checkout -b feature/nuova-funzionalita`)
3. Commit delle modifiche (`git commit -m 'Add: nuova funzionalita'`)
4. Push (`git push origin feature/nuova-funzionalita`)
5. Apri una Pull Request

---

## Licenza

Distribuito sotto licenza **MIT**. Vedi [`LICENSE`](LICENSE) per i dettagli.

---

<p align="center">
  Fatto con ❤️ usando <a href="https://laravel.com">Laravel</a> e <a href="https://tailwindcss.com">Tailwind CSS</a>
</p>
