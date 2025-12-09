<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        $memberships = [
            [
                'name' => 'Básico',
                'slug' => 'basico',
                'description' => 'Plan básico para artistas que están comenzando',
                'price' => 299.00,
                'duration_days' => 30,
                'max_photos' => 10,
                'featured' => false,
                'priority_ranking' => false,
                'ranking_bonus' => 0,
                'advanced_stats' => false,
                'support_priority' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Plan premium con más beneficios y visibilidad',
                'price' => 599.00,
                'duration_days' => 30,
                'max_photos' => null, // Ilimitado
                'featured' => true,
                'priority_ranking' => true,
                'ranking_bonus' => 50,
                'advanced_stats' => true,
                'support_priority' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'VIP',
                'slug' => 'vip',
                'description' => 'Plan VIP con todos los beneficios y máxima visibilidad',
                'price' => 999.00,
                'duration_days' => 30,
                'max_photos' => null, // Ilimitado
                'featured' => true,
                'priority_ranking' => true,
                'ranking_bonus' => 100,
                'advanced_stats' => true,
                'support_priority' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($memberships as $membership) {
            Membership::create($membership);
        }
    }
}

