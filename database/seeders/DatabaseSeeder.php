<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class
        ]);

        Customer::factory(1000)->create();

        $items = \App\Models\Item::all();

        Purchase::factory(10000)->create()
            ->each(function(Purchase $purchase) use($items) {
                $itemsForPurchase = $items->random(rand(1, 3))->pluck('id')->toArray();
                
                foreach ($itemsForPurchase as $itemID) {
                    $purchase->items()->attach(
                        $itemID,
                        ['quantity' => rand(1, 5)]
                    );
                }
            });
    }


    
}
