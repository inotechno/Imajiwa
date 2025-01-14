<?php

namespace Database\Seeders;

use App\Models\CategoryProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryProject::create([
            'name' => 'Design',
            'slug' => 'Design',
            'description' => 'Creative visual design projects including branding, illustration, and graphic design.',
        ]);

        CategoryProject::create([
            'name' => 'Motion Graphic',
            'slug' => 'Motion Graphic',
            'description' => 'Projects involving animation, video effects, and motion visuals.',
        ]);

        CategoryProject::create([
            'name' => 'Technology',
            'slug' => 'Technology',
            'description' => 'Technology-focused projects including app development, web design, and digital experiences.',
        ]);
    }
}
