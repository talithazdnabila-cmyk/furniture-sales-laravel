<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Transaction;
use App\Models\ShippingCity;

echo "=== Latest transaction with NULL kota ===\n";
$nullKota = Transaction::whereNull('kota')->latest()->first();

if ($nullKota) {
    echo "Found transaction with NULL kota:\n";
    echo "ID: {$nullKota->id}\n";
    echo "city_id: {$nullKota->city_id}\n";
    echo "nama_penerima: {$nullKota->nama_penerima}\n";
    echo "created_at: {$nullKota->created_at}\n\n";
    
    // Check ShippingCity
    $city = ShippingCity::find($nullKota->city_id);
    if ($city) {
        echo "=== ShippingCity Data ===\n";
        echo "ID: {$city->id}\n";
        echo "city_name: {$city->city_name}\n";
        echo "shipping_cost: {$city->shipping_cost}\n";
    } else {
        echo "ShippingCity ID {$nullKota->city_id} NOT FOUND!\n";
    }
} else {
    echo "No transaction with NULL kota found.\n";
}

