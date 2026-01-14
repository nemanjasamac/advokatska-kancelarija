@echo off
echo ========================================
echo   Advokatska Kancelarija - Instalacija
echo ========================================
echo.

echo [1/7] Instaliram PHP zavisnosti...
call composer install

echo [2/7] Instaliram NPM zavisnosti...
call npm install

echo [3/7] Kreiram .env fajl...
if not exist ".env" (
    copy .env.example .env
) else (
    echo .env vec postoji, preskacemo...
)

echo [4/7] Generisem application key...
call php artisan key:generate

echo [5/7] Pokrecem migracije i seedere...
echo.
echo VAZNO: Pre ovog koraka moras kreirati bazu 'advokatska_kancelarija' u MySQL!
echo.
pause
call php artisan migrate --seed

echo [6/7] Buildujem frontend...
call npm run build

echo.
echo ========================================
echo   Instalacija zavrsena!
echo ========================================
echo.
echo   Pokreni 'start.bat' za pokretanje servera
echo.
echo   Login kredencijali:
echo   - Admin: admin@kancelarija.rs / password
echo   - Klijent: klijent@demo.rs / password
echo.
pause
