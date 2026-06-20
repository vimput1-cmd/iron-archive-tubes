<?php

/*
|--------------------------------------------------------------------------
| SELENIUM — STATE TRANSITION (Otorisasi Role) — UI Test
|--------------------------------------------------------------------------
| Penanggung : Vincent Imanuel Putra (102062400026)
| Prasyarat  : php artisan migrate:fresh --seed  +  php artisan serve  +  chromedriver --port=4444
| Skenario:
|   T4. Login user biasa -> akses /users -> tampil "AKSES DITOLAK" (403)
|   T5. Login admin      -> akses /users -> tampil "MANAJEMEN PERSONEL"
*/

require __DIR__ . '/bootstrap.php';

use Facebook\WebDriver\WebDriverBy;

function loginAs(\Facebook\WebDriver\Remote\RemoteWebDriver $driver, string $email, string $password): void
{
    $driver->manage()->deleteAllCookies();           // reset state Tamu dulu
    $driver->get(appUrl('/login'));
    $driver->findElement(WebDriverBy::id('email'))->sendKeys($email);
    $driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
    $driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'))->click();
    waitUrlContains($driver, '/home');
}

$driver = makeDriver();

try {
    // ---- T4: user biasa -> /users -> 403 (AKSES DITOLAK) ----
    echo "[Info] Memulai T4 (User biasa akses /users)...\n";
    loginAs($driver, 'user@ironarchive.test', 'password');
    $driver->get(appUrl('/users'));
    $body = $driver->findElement(WebDriverBy::tagName('body'))->getText();
    check('T4 User biasa ditolak di /users (AKSES DITOLAK)', stripos($body, 'DITOLAK') !== false || stripos($body, '403') !== false);

    // ---- T5: admin -> /users -> boleh (MANAJEMEN PERSONEL) ----
    echo "[Info] Memulai T5 (Admin akses /users)...\n";
    loginAs($driver, 'admin@ironarchive.test', 'password');
    $driver->get(appUrl('/users'));
    $body = $driver->findElement(WebDriverBy::tagName('body'))->getText();
    check('T5 Admin boleh akses manajemen personel', stripos($body, 'MANAJEMEN PERSONEL') !== false);

} catch (\Throwable $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    try { $driver->takeScreenshot(__DIR__ . '/Error_Selenium_Role.png'); echo "Screenshot kegagalan disimpan.\n"; } catch (\Throwable $x) {}
} finally {
    $driver->quit();
    summary();
}
