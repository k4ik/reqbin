<?php

use App\Database\Connection;

if (!getenv('DB_PATH')) {
    putenv('DB_PATH=:memory:');
}

uses()->beforeEach(function () {
    $pdo = Connection::get();
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            bin VARCHAR(255) NOT NULL UNIQUE,
            created_at INTEGER NOT NULL,
            expires_at INTEGER NOT NULL
        );

        CREATE TABLE IF NOT EXISTS requests (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            bin_id INTEGER NOT NULL,
            method VARCHAR(10) NOT NULL,
            headers TEXT NOT NULL,
            body TEXT,
            query_params TEXT,
            ip VARCHAR(45),
            created_at INTEGER NOT NULL,
            FOREIGN KEY (bin_id) REFERENCES bins(id) ON DELETE CASCADE
        );
    ");
})->in('Unit', 'Feature');