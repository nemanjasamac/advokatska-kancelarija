@echo off
echo ========================================
echo   Advokatska Kancelarija - Pokretanje
echo ========================================
echo.

:: Provera da li postoji vendor folder
if not exist "vendor" (
    echo [1/6] Instaliram PHP zavisnosti...
    call composer install
) else (
    echo [1/6] PHP zavisnosti vec instalirane.
)

:: Provera da li postoji node_modules folder
if not exist "node_modules" (
    echo [2/6] Instaliram NPM zavisnosti...
    call npm install
) else (
    echo [2/6] NPM zavisnosti vec instalirane.
)

:: Provera da li postoji .env fajl
if not exist ".env" (
    echo [3/6] Kreiram .env fajl...
    copy .env.example .env
    echo [4/6] Generisem application key...
    call php artisan key:generate
) else (
    echo [3/6] .env fajl vec postoji.
    echo [4/6] Application key vec generisan.
)

:: Build frontend assets
echo [5/6] Buildujem frontend...
call npm run build

:: Pokreni server
echo [6/6] Pokrecem server...
echo.
echo ========================================
echo   Server pokrenut na http://127.0.0.1:8000
echo ========================================
echo.
echo   Login kredencijali:
echo   - Admin: admin@kancelarija.rs / password
echo   - Klijent: klijent@demo.rs / password
echo.
echo   Pritisni Ctrl+C za zaustavljanje servera
echo ========================================
echo.

php artisan serve
