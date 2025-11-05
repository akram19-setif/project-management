<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// Disable foreign key checks
DB::statement('PRAGMA foreign_keys = OFF');

echo "Dropping tables...\n";

// Drop tables if they exist
if (Schema::hasTable('tasks')) {
    Schema::drop('tasks');
    echo "Tasks table dropped.\n";
}

if (Schema::hasTable('projects')) {
    Schema::drop('projects');
    echo "Projects table dropped.\n";
}

// Re-enable foreign key checks
DB::statement('PRAGMA foreign_keys = ON');

echo "Done!\n";