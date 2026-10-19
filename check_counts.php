<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "CATEGORIES WITH PRODUCTS:\n";
foreach (\App\Models\Category::withCount(['products' => function($q) { $q->where('is_active', true); }])->get() as $c) {
    echo "ID: {$c->id} | {$c->name} ({$c->slug}) -> {$c->products_count} active products\n";
}

echo "\nAGE GROUPS WITH PRODUCTS:\n";
foreach (\App\Models\AgeGroup::withCount(['products' => function($q) { $q->where('is_active', true); }])->get() as $a) {
    echo "ID: {$a->id} | {$a->name} ({$a->slug}) -> {$a->products_count} active products\n";
}
