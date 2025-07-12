<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Réviser les stocks',
                'description' => 'Vérifier et mettre à jour les niveaux de stock de tous les produits',
                'status' => 'todo',
                'deadline' => now()->addDays(2),
            ],
            [
                'name' => 'Valider les commandes en attente',
                'description' => 'Traiter les commandes en attente de validation',
                'status' => 'doing',
                'deadline' => now()->addDay(),
            ],
            [
                'name' => 'Contacter les fournisseurs',
                'description' => 'Prendre contact avec les fournisseurs pour les produits en rupture',
                'status' => 'todo',
                'deadline' => now()->addDays(5),
            ],
            [
                'name' => 'Préparer le rapport mensuel',
                'description' => 'Générer le rapport de vente du mois en cours',
                'status' => 'done',
                'deadline' => now()->subDays(1),
            ],
            [
                'name' => 'Mettre à jour les prix',
                'description' => 'Réviser et mettre à jour les prix des produits',
                'status' => 'todo',
                'deadline' => now()->addWeek(),
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
} 