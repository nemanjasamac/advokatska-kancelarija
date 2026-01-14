# Advokatska Kancelarija

Web aplikacija za upravljanje advokatskom kancelarijom. Omogućava evidenciju klijenata, pravnih predmeta, dokumenata i termina (sastanaka i ročišta).

## 📋 Opis implementacije

### Korišćene tehnologije

| Kategorija | Tehnologija | Verzija |
|------------|-------------|---------|
| **Backend** | Laravel | 11.x |
| **PHP** | PHP | 8.2 |
| **Frontend** | Tailwind CSS | 3.x |
| **Build tool** | Vite | 6.x |
| **Autentifikacija** | Laravel Breeze | 2.3 |
| **Baza podataka** | MySQL | 8.x |
| **Code Generator** | Laravel Blueprint | 2.x |
| **Code Style** | Laravel Pint | 1.x |
| **Testing** | PHPUnit | 11.x |
| **CI/CD** | GitHub Actions | - |

### Biblioteke i alati
- **Laravel Breeze** - autentifikacija (login, logout, password reset)
- **Laravel Blueprint** - generisanje modela, migracija, kontrolera i factory-a
- **Laravel Pint** - automatsko formatiranje koda po PSR-12 standardu
- **Tailwind CSS** - utility-first CSS framework za stilizovanje
- **Vite** - build tool za kompajliranje CSS i JavaScript resursa

---

## 🔗 GitHub repozitorijum

**Link:** https://github.com/nemanjasamac/advokatska-kancelarija

---

## 📜 Blueprint skripta

Sledeći `draft.yaml` fajl korišćen je za generisanje modela, migracija, kontrolera i factory-a:

```yaml
models:
  Client:
    name: string
    client_type: enum:fizicko,pravno
    email: string nullable
    phone: string nullable
    address: string nullable
    note: text nullable
    relationships:
      hasMany: LegalCase

  LegalCase:
    title: string
    case_type: string
    court: string nullable
    opponent: string nullable
    status: enum:novi,otvoren,u_toku,na_cekanju,zatvoren
    opened_at: date
    closed_at: date nullable
    client_id: id foreign:clients
    user_id: id foreign:users
    relationships:
      belongsTo: Client, User
      hasMany: Document, Appointment

  Document:
    file_name: string
    file_path: string
    document_type: string
    description: text nullable
    uploaded_at: datetime
    legal_case_id: id foreign:legal_cases
    user_id: id foreign:users
    relationships:
      belongsTo: LegalCase, User

  Appointment:
    date_time: datetime
    type: enum:sastanak,rociste
    location: string nullable
    note: text nullable
    legal_case_id: id foreign:legal_cases nullable
    user_id: id foreign:users
    relationships:
      belongsTo: LegalCase, User

controllers:
  Client:
    resource: web

  LegalCase:
    resource: web

  Document:
    resource: web

  Appointment:
    resource: web
```

**Pokretanje Blueprint-a:**
```bash
php artisan blueprint:build
```

---

## ⚙️ GitHub Actions (CI/CD)

Sadržaj `.github/workflows/ci.yml` fajla:

```yaml
name: CI

on:
  push:
    branches: [ main, master ]
  pull_request:
    branches: [ main, master ]

jobs:
  tests:
    runs-on: ubuntu-latest

    steps:
    - name: Checkout code
      uses: actions/checkout@v4

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, json, bcmath, pdo, pdo_sqlite
        coverage: none

    - name: Install Composer dependencies
      run: composer install --prefer-dist --no-progress --no-interaction

    - name: Setup Node.js
      uses: actions/setup-node@v4
      with:
        node-version: '20'
        cache: 'npm'

    - name: Install NPM dependencies
      run: npm ci

    - name: Build assets
      run: npm run build

    - name: Copy environment file
      run: cp .env.example .env

    - name: Generate application key
      run: php artisan key:generate

    - name: Run Pint (Code Style)
      run: vendor/bin/pint --test

    - name: Run tests
      run: php artisan test
      env:
        DB_CONNECTION: sqlite
        DB_DATABASE: ":memory:"
```

---

## 📁 Struktura projekta i dokumentacija fajlova

### Modeli (`app/Models/`)

| Model | Generisano | Opis |
|-------|------------|------|
| `User.php` | Laravel default + ručno | Korisnici sistema (admini i klijenti). Dodato polje `role` i `client_id`. |
| `Client.php` | Blueprint | Klijenti advokatske kancelarije (fizička/pravna lica). |
| `LegalCase.php` | Blueprint | Pravni predmeti sa statusima i vezom na klijenta. |
| `Document.php` | Blueprint | Dokumenti vezani za predmete (tužbe, ugovori, dokazi). |
| `Appointment.php` | Blueprint | Termini (sastanci i ročišta). |

### Kontroleri (`app/Http/Controllers/`)

| Kontroler | Generisano | Opis |
|-----------|------------|------|
| `ClientController.php` | Blueprint | CRUD operacije za klijente. |
| `LegalCaseController.php` | Blueprint | CRUD operacije za pravne predmete. |
| `DocumentController.php` | Blueprint | CRUD operacije za dokumente. |
| `AppointmentController.php` | Blueprint | CRUD operacije za termine. |
| `DashboardController.php` | Ručno | Prikaz admin dashboard-a sa statistikom. |
| `ClientPortalController.php` | Ručno | Portal za klijente - pregled predmeta i zakazivanje. |
| `ProfileController.php` | Breeze | Upravljanje korisničkim profilom. |
| `Auth/*` | Breeze | Autentifikacija (login, logout, password reset). |

### Migracije (`database/migrations/`)

| Migracija | Generisano | Opis |
|-----------|------------|------|
| `create_users_table` | Laravel | Osnovna tabela korisnika. |
| `create_clients_table` | Blueprint | Tabela klijenata. |
| `create_legal_cases_table` | Blueprint | Tabela pravnih predmeta. |
| `create_documents_table` | Blueprint | Tabela dokumenata. |
| `create_appointments_table` | Blueprint | Tabela termina. |
| `add_role_to_users_table` | Ručno | Dodaje `role` enum i `client_id` FK u users tabelu. |

### Seederi (`database/seeders/`)

| Seeder | Generisano | Opis |
|--------|------------|------|
| `UserSeeder.php` | Ručno | Kreira admin korisnike. |
| `ClientSeeder.php` | Ručno | Kreira test klijente. |
| `LegalCaseSeeder.php` | Ručno | Kreira test predmete. |
| `DocumentSeeder.php` | Ručno | Kreira test dokumente. |
| `AppointmentSeeder.php` | Ručno | Kreira test termine. |
| `ClientUserSeeder.php` | Ručno | Kreira demo naloge za klijente. |

### Middleware (`app/Http/Middleware/`)

| Middleware | Generisano | Opis |
|------------|------------|------|
| `AdminMiddleware.php` | Ručno | Proverava da li je korisnik admin. Štiti `/admin/*` rute. |

### Views (`resources/views/`)

| Folder | Generisano | Opis |
|--------|------------|------|
| `layouts/admin.blade.php` | Ručno | Glavni layout za admin panel sa sidebar navigacijom. |
| `layouts/portal.blade.php` | Ručno | Layout za klijentski portal. |
| `admin/*` | Ručno | Svi view-ovi za admin panel (CRUD stranice). |
| `portal/*` | Ručno | View-ovi za klijentski portal. |
| `auth/*` | Breeze | Login, register, password reset stranice. |
| `components/*` | Breeze | Blade komponente za forme. |

### Testovi (`tests/`)

| Test | Opis |
|------|------|
| `Feature/ClientTest.php` | Testira CRUD operacije za klijente. |
| `Feature/LegalCaseTest.php` | Testira CRUD operacije za predmete. |
| `Feature/Auth/*` | Testira autentifikaciju (Breeze). |
| `Feature/ProfileTest.php` | Testira upravljanje profilom. |

**Ukupno: 35 testova**

---

## 🔐 Sistem uloga

Aplikacija ima dva tipa korisnika:

| Uloga | Pristup | Opis |
|-------|---------|------|
| **Admin** | `/admin/*` | Advokati - puni pristup svim funkcionalnostima. |
| **Client** | `/portal/*` | Klijenti - pregled svojih predmeta i zakazivanje termina. |

---

## 🚀 Instalacija i pokretanje

```bash
# Kloniraj repozitorijum
git clone https://github.com/nemanjasamac/advokatska-kancelarija.git
cd advokatska-kancelarija

# Instaliraj zavisnosti
composer install
npm install

# Podesi environment
cp .env.example .env
php artisan key:generate

# Kreiraj bazu i pokreni migracije
php artisan migrate --seed

# Builduj frontend
npm run build

# Pokreni server
php artisan serve
```

Ili koristi `setup.bat` (Windows) za automatsku instalaciju.

---

## 👤 Demo nalozi

| Uloga | Email | Lozinka |
|-------|-------|---------|
| Admin | admin@kancelarija.rs | password |
| Admin | nsamac6623it@raf.rs | password |
| Klijent | klijent@demo.rs | password |
| Klijent | klijent@raf.rs | password |

---

## 📸 Screenshotovi aplikacije

<img width="2552" height="936" alt="image" src="https://github.com/user-attachments/assets/3a083b17-ef37-42f4-8aa2-7f86606e4550" />
<img width="2555" height="927" alt="image" src="https://github.com/user-attachments/assets/8f292037-402c-4967-bdca-348ebacb480f" />
<img width="2550" height="936" alt="image" src="https://github.com/user-attachments/assets/070edfe0-9c1e-408e-b24b-7596e58e154e" />
<img width="1223" height="944" alt="image" src="https://github.com/user-attachments/assets/0d93ec03-45f5-4cee-b340-e8083600bfee" />
<img width="2539" height="939" alt="image" src="https://github.com/user-attachments/assets/bf4a0461-c622-492f-ba9b-38a9499bff7c" />


---

## 🎨 Figma dizajn

https://www.figma.com/proto/MQqhrWJIBd4MjEgEBapSRO/Untitled?node-id=0-1&t=eN72PClc3wjXD3gM-1
https://www.figma.com/design/MQqhrWJIBd4MjEgEBapSRO/Untitled?node-id=0-1&m=dev&t=eN72PClc3wjXD3gM-1

---

## 📊 Dijagram baze podataka

<img width="1904" height="933" alt="image" src="https://github.com/user-attachments/assets/0c2e84bc-b4db-4910-a446-eeb325bf8506" />

---

## 📝 Licenca

MIT License
