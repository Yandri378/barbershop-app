<?php

if (getenv('VERCEL') && getenv('DB_CONNECTION') === 'sqlite') {
    $sourceDatabase = __DIR__ . '/../database/database.sqlite';
    $runtimeDatabase = '/tmp/database.sqlite';

    if (is_file($sourceDatabase) && ! is_file($runtimeDatabase)) {
        copy($sourceDatabase, $runtimeDatabase);
    }
}

require __DIR__ . '/../public/index.php';
