<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Download;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CartAndCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic category
        Category::create([
            'name' => 'أدوات تعليمية',
            'slug' => 'educational-tools',
            'is_active' => true,
        ]);
    }

    /** @test */
    public function a_user_can_add_a_product_to_cart()
    {
        $product = Product::create([
            'name' => 'صندوق التخاطب',
            'slug' => 'speech-box',
            'price' => 250.00,
            'type' => 'physical',
            'stock' => 10,
            'is_active' => true,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertRedirect();
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);
    }

    /** @test */
    public function a_user_cannot_add_more_than_available_stock()
    {
        $product = Product::create([
            'name' => 'صندوق التخاطب المحدود',
            'slug' => 'speech-box-limited',
            'price' => 250.00,
            'type' => 'physical',
            'stock' => 3,
            'is_active' => true,
        ]);

        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('cart'));
    }

    /** @test */
    public function a_user_can_place_an_order_and_upload_a_payment_screenshot()
    {
        Storage::fake('public');

        $product = Product::create([
            'name' => 'كتاب تدريبات الحروف',
            'slug' => 'letters-book',
            'price' => 100.00,
            'type' => 'digital',
            'digital_file_path' => 'private_downloads/sample.pdf',
            'digital_file_name' => 'sample.pdf',
            'stock' => 0,
            'is_active' => true,
        ]);

        // Put in session cart
        session(['cart' => [
            $product->id => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 100.00,
                'quantity' => 1,
                'image' => null,
                'type' => 'digital',
            ]
        ]]);

        $screenshot = UploadedFile::fake()->image('payment_proof.jpg');

        $response = $this->post(route('checkout.store'), [
            'customer_name' => 'أحمد العميل',
            'customer_email' => 'client@test.com',
            'customer_phone' => '01012345678',
            'shipping_governorate' => 'القاهرة',
            'shipping_address' => 'شارع التحرير، وسط البلد',
            'payment_method' => 'instapay',
            'payment_screenshot' => $screenshot,
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'أحمد العميل',
            'customer_phone' => '01012345678',
            'payment_method' => 'instapay',
        ]);

        $order = Order::first();
        $response->assertRedirect(route('checkout.success', $order->order_number));

        // Assert download token was created
        $this->assertDatabaseHas('downloads', [
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function a_user_can_securely_download_digital_product_by_valid_token()
    {
        Storage::fake('local');

        // Create secure file
        Storage::disk('local')->put('private_downloads/sample_letters.pdf', 'dummy pdf content');

        $product = Product::create([
            'name' => 'كتاب تدريبات الحروف',
            'slug' => 'letters-book',
            'price' => 100.00,
            'type' => 'digital',
            'digital_file_path' => 'private_downloads/sample_letters.pdf',
            'digital_file_name' => 'sample_letters.pdf',
            'stock' => 0,
            'is_active' => true,
        ]);

        $user = User::create([
            'name' => 'أحمد العميل',
            'email' => 'client@test.com',
            'password' => bcrypt('password123'),
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => '2M-TEST-123',
            'customer_name' => 'أحمد العميل',
            'customer_email' => 'client@test.com',
            'customer_phone' => '01012345678',
            'shipping_governorate' => 'القاهرة',
            'shipping_address' => 'العنوان هنا',
            'shipping_fee' => 0.00,
            'subtotal' => 100.00,
            'discount_total' => 0.00,
            'total' => 100.00,
            'payment_method' => 'instapay',
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        $download = Download::create([
            'order_id' => $order->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'token' => 'secure-token-xyz',
            'download_count' => 0,
            'max_downloads' => 5,
            'expires_at' => now()->addDays(5),
        ]);

        $response = $this->get(route('download', 'secure-token-xyz'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=sample_letters.pdf');
        $this->assertEquals(1, $download->refresh()->download_count);
    }
}
