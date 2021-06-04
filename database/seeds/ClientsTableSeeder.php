<?php

use Illuminate\Database\Seeder;
use App\Models\Client;
class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Client::create([
            'name' => 'Hussien Attia',
            'phone' => ['01095454494','0226548292'],
            'address' => 'Elmatary Cairo EGYPT'
        ]);
    }
}
