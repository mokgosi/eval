<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;
use App\Type;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'id_number' => '7900000000000',
            'first_names' => 'Name',
            'last_name' => 'Surname'
        ]);

        factory(App\User::class, 5)->create();

        Type::create([
            'type' => 'record_number',
            'description' => 'transaction number',
            'deleted' => '0'
        ]);

        Type::create([
            'type' => 'msisdn',
            'description' => 'Cellphone number',
            'deleted' => '0'
        ]);

        Type::create([
            'type' => 'network',
            'description' => 'Cellphone Network',
            'deleted' => '0'
        ]);

        Type::create([
            'type' => 'points',
            'description' => 'Earned points',
            'deleted' => '0'
        ]);

        Type::create([
            'type' => 'card_number',
            'description' => 'Card number',
            'deleted' => '0'
        ]);

        Type::create([
            'type' => 'gender',
            'description' => 'Male or Female',
            'deleted' => '0'
        ]);
    }
}
