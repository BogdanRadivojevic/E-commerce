<?php

namespace Database\Seeders;

use App\Models\Inbox;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductService;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kreiranje uloga
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $customerRole = Role::factory()->create(['name' => 'customer']);

        // Create users and assign roles
        $admins = User::factory(5)->create(['role_id' => $adminRole->id]);
        $customers = User::factory(10)->create(['role_id' => $customerRole->id]);
//
//        // Kreiranje korisnika i dodela rola
//        $roles = Role::all(); // Dohvata sve
//        User::factory(10)->create()->each(function ($user) use ($roles) {
//            $user->role_id = $roles->random()->id;
//            $user->save();
//        });

        // Kreiranje proizvoda
        Product::factory(20)->create();

        // Kreiranje narudžbine
        Order::factory()
            ->count(20)
            ->create()
            ->each(function ($order) {
                $products = Product::inRandomOrder()->take(rand(1, 5))->get(); // Uzima nasumične proizvode
                $totalPrice = 0;

                foreach ($products as $product) {
                    $quantity = rand(1, 3); // Nasumična količina po proizvodu
                    $order->products()->attach($product->id, ['quantity' => $quantity]);
                    $totalPrice += $product->price * $quantity;
                }

                $order->update(['total_price' => $totalPrice]); // Ažuriraj ukupnu cenu
            });

        // Kreiraj povezane proizvode u narudžbinama
//        \App\Models\OrderProduct::factory(30)->create();

        // Kreiraj nekoliko korisnika i za svakog korisnika nekoliko servisa
        $customers->each(function ($customer) use ($admins) {
            ProductService::factory(rand(1, 3))->create([
                'auth_user_id' => $admins->random()->id, // Assign to a random admin
                'service_user_id' => $customer->id, // Service requested by this customer
            ]);
        });

        // Kreiranje poruka u inboxu
        Inbox::factory(5)->create();

        DB::table('users')->insert([
            'name' => 'Pera',
            'email' => 'pera@example.com',
            'password' => Hash::make('perapera'), // Unesite lozinku ovdje
            'role_id' => 1, // Pretpostavka: role_id 1 postoji u bazi podataka
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

//        \App\Models\Role::factory(2)->create(['name' => 'admin']);
//        \App\Models\Role::factory(5)->create(['name' => 'customer']);
//
//        \App\Models\User::factory(10)->create();
//        \App\Models\Product::factory(15)->create();
//        \App\Models\Order::factory(20)->create();
//        \App\Models\ProductService::factory(10)->create();
//        \App\Models\Inbox::factory(5)->create();
    }
}
