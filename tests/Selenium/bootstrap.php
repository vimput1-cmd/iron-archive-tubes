<?php

/*
|--------------------------------------------------------------------------
| Bootstrap Selenium (php-webdriver)
|--------------------------------------------------------------------------
| Helper bersama untuk semua skenario UI Test (State Transition).
| Butuh paket: composer require php-webdriver/webdriver --dev
|
| Cara pakai (3 terminal):
|   1) php artisan migrate:fresh --seed     (siapkan akun admin/user + data)
|   2) php artisan serve                    (APP_URL=http://127.0.0.1:8000)
|   3) chromedriver --port=4444             (atau Selenium Server)
| Lalu: php tests/Selenium/auth_test.php
*/

error_reporting(E_ALL & ~E_DEPRECATED);  // bungkam warning deprecation dari php-webdriver

require __DIR__ . '/../../vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

function makeDriver(): RemoteWebDriver
{
    $host = getenv('SELENIUM_HOST') ?: 'http://localhost:4444';
    return RemoteWebDriver::create($host, DesiredCapabilities::chrome());
}

function appUrl(string $path = ''): string
{
    $base = getenv('APP_URL') ?: 'http://127.0.0.1:8000';
    return rtrim($base, '/') . $path;
}

/**
 * Tunggu sampai URL memuat $needle (anti-versi, pakai closure — tidak butuh
 * WebDriverExpectedCondition::urlContains yang tidak ada di sebagian versi).
 */
function waitUrlContains(RemoteWebDriver $driver, string $needle, int $timeout = 10): void
{
    $driver->wait($timeout)->until(function ($d) use ($needle) {
        return str_contains($d->getCurrentURL(), $needle);
    });
}

/** Tunggu sampai elemen dengan id tertentu muncul. */
function waitElementById(RemoteWebDriver $driver, string $id, int $timeout = 10): void
{
    $driver->wait($timeout)->until(function ($d) use ($id) {
        return count($d->findElements(\Facebook\WebDriver\WebDriverBy::id($id))) > 0;
    });
}

$GLOBALS['__pass'] = 0;
$GLOBALS['__fail'] = 0;

function check(string $label, bool $cond): void
{
    if ($cond) {
        $GLOBALS['__pass']++;
        echo "  [PASS] {$label}\n";
    } else {
        $GLOBALS['__fail']++;
        echo "  [FAIL] {$label}\n";
    }
}

function summary(): void
{
    echo "\n=== HASIL SELENIUM: {$GLOBALS['__pass']} PASS / {$GLOBALS['__fail']} FAIL ===\n";
    exit($GLOBALS['__fail'] > 0 ? 1 : 0);
}
