<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('achievements') as $type => $achievements) {
            $this->createAcheivements($type, $achievements);
        }
    }

    private function createAcheivements($type, $achievements): void {
        foreach ($achievements as $count => $name) {
            Achievement::firstOrCreate([
                'name' => $name,
                'count_required' => $count,
                'type' => $type
            ]);
        }
    }
}
