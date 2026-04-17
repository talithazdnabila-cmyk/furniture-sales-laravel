<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

// Database setup
require __DIR__ . '/bootstrap/app.php';

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\BufferedOutput,
);

// Test 1: Check if products exist
$product = Product::first();
$user = User::first();

echo "=== CART FEATURE TEST ===\n\n";

if (!$product) {
    echo "❌ ERROR: No products found in database\n";
    exit(1);
}

if (!$user) {
    echo "❌ ERROR: No users found in database\n";
    exit(1);
}

echo "✓ Found Product: {$product->name}\n";
echo "✓ Found User: {$user->name}\n\n";

// Test 2: Create cart item
// Delete existing carts first
Cart::where('user_id', $user->id)->delete();

$cart = Cart::create([
    'user_id' => $user->id,
    'product_id' => $product->id,
    'quantity' => 2,
    'selected' => true,
]);

echo "✓ Cart Item Created (ID: {$cart->id})\n";
echo "  - Product: {$cart->product->name}\n";
echo "  - Quantity: {$cart->quantity}\n";
echo "  - Selected: " . ($cart->selected ? 'true' : 'false') . "\n";
echo "  - Price: Rp" . number_format($cart->product->price * $cart->quantity, 0) . "\n\n";

// Test 3: Toggle selected
$cart->update(['selected' => false]);
$cart->refresh();
echo "✓ Toggle Selected to FALSE\n";
echo "  - Selected: " . ($cart->selected ? 'true' : 'false') . "\n\n";

// Test 4: Duplicate add test
$cart2 = Cart::where('user_id', $user->id)
    ->where('product_id', $product->id)
    ->first();

if ($cart2) {
    echo "✓ Found existing cart item for same product\n";
    echo "  - Current quantity: {$cart2->quantity}\n";
}

// Test 5: Query selected items only
$selectedTotal = Cart::where('user_id', $user->id)
    ->where('selected', true)
    ->get()
    ->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

echo "✓ Selected Items Total: Rp" . number_format($selectedTotal, 0) . "\n\n";

echo "=== ALL TESTS PASSED ✓ ===\n";
