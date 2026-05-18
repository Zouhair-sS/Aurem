<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::latest()->first();
        $userId = $user->id;

        // Clear existing data for this user
        DB::table('expenses')->where('user_id', $userId)->delete();
        DB::table('incomes')->where('user_id', $userId)->delete();
        DB::table('categories')->where('user_id', $userId)->delete();

        // System default category IDs
        // 1=Alimentation, 2=Transport, 3=Logement, 4=Santé, 5=Loisirs
        // 6=Vêtements, 8=Abonnements, 9=Restaurant
        // 10=Salaire, 11=Freelance, 13=Autre revenu

        // === INCOMES ===
        $incomes = [
            ['category_id' => 10, 'amount' => 8500,  'description' => 'Salaire mars',           'received_at' => '2026-03-01'],
            ['category_id' => 10, 'amount' => 8500,  'description' => 'Salaire avril',          'received_at' => '2026-04-01'],
            ['category_id' => 10, 'amount' => 8500,  'description' => 'Salaire mai',            'received_at' => '2026-05-01'],
            ['category_id' => 11, 'amount' => 2200,  'description' => 'Projet site e-commerce', 'received_at' => '2026-03-10'],
            ['category_id' => 11, 'amount' => 1500,  'description' => 'Dashboard client',       'received_at' => '2026-04-15'],
            ['category_id' => 11, 'amount' => 800,   'description' => 'Design web landing',     'received_at' => '2026-05-04'],
            ['category_id' => 13, 'amount' => 500,   'description' => 'Vente téléphone',        'received_at' => '2026-03-20'],
            ['category_id' => 13, 'amount' => 300,   'description' => 'Remboursement ami',      'received_at' => '2026-04-22'],
        ];

        foreach ($incomes as $inc) {
            DB::table('incomes')->insert([
                'user_id'     => $userId,
                'category_id' => $inc['category_id'],
                'amount'      => $inc['amount'],
                'description' => $inc['description'],
                'received_at' => $inc['received_at'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // === EXPENSES ===
        $expenses = [
            // Mars
            ['category_id' => 3,  'amount' => 3200, 'description' => 'Loyer mars',           'spent_at' => '2026-03-01'],
            ['category_id' => 1,  'amount' => 650,  'description' => 'Courses semaine 1',    'spent_at' => '2026-03-05'],
            ['category_id' => 1,  'amount' => 430,  'description' => 'Courses semaine 2',    'spent_at' => '2026-03-12'],
            ['category_id' => 9,  'amount' => 280,  'description' => 'Sortie restaurant',    'spent_at' => '2026-03-15'],
            ['category_id' => 2,  'amount' => 350,  'description' => 'Carburant + parking',  'spent_at' => '2026-03-08'],
            ['category_id' => 8,  'amount' => 120,  'description' => 'Netflix + Spotify',    'spent_at' => '2026-03-03'],
            ['category_id' => 5,  'amount' => 200,  'description' => 'Cinéma + bowling',     'spent_at' => '2026-03-22'],
            ['category_id' => 4,  'amount' => 200,  'description' => 'Consultation médecin', 'spent_at' => '2026-03-18'],
            ['category_id' => 6,  'amount' => 450,  'description' => 'Achat vêtements',      'spent_at' => '2026-03-25'],
            // Avril
            ['category_id' => 3,  'amount' => 3200, 'description' => 'Loyer avril',          'spent_at' => '2026-04-01'],
            ['category_id' => 1,  'amount' => 580,  'description' => 'Courses semaine 1',    'spent_at' => '2026-04-04'],
            ['category_id' => 1,  'amount' => 490,  'description' => 'Courses semaine 2',    'spent_at' => '2026-04-11'],
            ['category_id' => 9,  'amount' => 320,  'description' => 'Dîner en famille',     'spent_at' => '2026-04-18'],
            ['category_id' => 2,  'amount' => 300,  'description' => 'Uber + carburant',     'spent_at' => '2026-04-07'],
            ['category_id' => 8,  'amount' => 120,  'description' => 'Netflix + Spotify',    'spent_at' => '2026-04-03'],
            ['category_id' => 5,  'amount' => 350,  'description' => 'Escape game + café',   'spent_at' => '2026-04-19'],
            ['category_id' => 4,  'amount' => 150,  'description' => 'Pharmacie',            'spent_at' => '2026-04-25'],
            // Mai
            ['category_id' => 3,  'amount' => 3200, 'description' => 'Loyer mai',            'spent_at' => '2026-05-01'],
            ['category_id' => 1,  'amount' => 520,  'description' => 'Courses semaine 1',    'spent_at' => '2026-05-03'],
            ['category_id' => 9,  'amount' => 180,  'description' => 'Déjeuner client',      'spent_at' => '2026-05-06'],
            ['category_id' => 2,  'amount' => 280,  'description' => 'Carburant',            'spent_at' => '2026-05-05'],
            ['category_id' => 8,  'amount' => 120,  'description' => 'Netflix + Spotify',    'spent_at' => '2026-05-03'],
            ['category_id' => 5,  'amount' => 200,  'description' => 'Café + sortie',        'spent_at' => '2026-05-07'],
        ];

        foreach ($expenses as $exp) {
            DB::table('expenses')->insert([
                'user_id'     => $userId,
                'category_id' => $exp['category_id'],
                'amount'      => $exp['amount'],
                'description' => $exp['description'],
                'spent_at'    => $exp['spent_at'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('✅ Demo data inserted for user: ' . $user->email);
    }
}