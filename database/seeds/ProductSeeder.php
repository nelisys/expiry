<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('admin1234'),
        ]);

        factory(Product::class, 25)->create([
            'user_id' => $user->id,
        ]);
    }
}
