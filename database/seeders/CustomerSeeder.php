<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Jean Dupont',
                'address' => '123 Rue de la Paix, 75001 Paris',
                'phone' => '01 23 45 67 89',
                'email' => 'jean.dupont@email.com',
            ],
            [
                'name' => 'Marie Martin',
                'address' => '456 Avenue des Champs, 69001 Lyon',
                'phone' => '04 56 78 90 12',
                'email' => 'marie.martin@email.com',
            ],
            [
                'name' => 'Pierre Durand',
                'address' => '789 Boulevard Central, 13001 Marseille',
                'phone' => '04 91 23 45 67',
                'email' => 'pierre.durand@email.com',
            ],
            [
                'name' => 'Sophie Bernard',
                'address' => '321 Place de la République, 31000 Toulouse',
                'phone' => '05 61 34 56 78',
                'email' => 'sophie.bernard@email.com',
            ],
            [
                'name' => 'Lucas Petit',
                'address' => '654 Rue du Commerce, 44000 Nantes',
                'phone' => '02 40 67 89 01',
                'email' => 'lucas.petit@email.com',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
} 