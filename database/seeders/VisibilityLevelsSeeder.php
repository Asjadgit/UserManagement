<?php

namespace Database\Seeders;

use App\Models\VisibilityLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Flysystem\Visibility;

class VisibilityLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Visibility Levels
        // Define Visibility Levels
        $visibilityLevels = [
            [
                'name' => 'Item owner',
                'description' => 'Visible to owner, Deals admins, parent visibility groups',
            ],
            [
                'name' => "Item owner's visibility group",
                'description' => 'Visible to owner, Deals admins, users in the same visibility and parent group',
            ],
            [
                'name' => "Item owner's visibility and sub-groups",
                'description' => 'Visible to owner, Deals admins, users in the same visibility groups, parent group, and sub-groups',
            ],
            [
                'name' => 'All Users',
                'description' => 'Visible to everyone in the company',
            ],
        ];

        // Insert each visibility level into the database
        foreach ($visibilityLevels as $level) {
            VisibilityLevel::create($level);
        }
    }
}
