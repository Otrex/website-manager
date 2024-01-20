<?php

namespace App\Core;

use Dotenv\Dotenv;

class EnvLoader
{
  public static function load(string $path) {
    Dotenv::createUnsafeImmutable($path)->load();
  }
}
