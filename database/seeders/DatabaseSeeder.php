<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Purchase;
use App\Models\Item;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
        ]);
        Customer::factory(1000)->create();

        $items = Item::all();
        Purchase::factory(100)->create()
            ->each(function (Purchase $purchase) use ($items) {
                $purchase->items()->attach(
                    $items->random(rand(1, 3))->pluck('id')->toArray(), // 1~3個のitemをpurchaseにランダムに紐づけ
                    ['quantity' => rand(1, 5)]
                );
            });
    }
}
