<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('badges') as $countRequired => $name) {
            Badge::firstOrCreate([
                'name' => $name,
                'count_required' => $countRequired
            ]);
        }
    }
}
