<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Articles related to technology advancements and innovations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health',
                'description' => 'Topics covering health, wellness, and medical advancements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Travel',
                'description' => 'Guides and tips for traveling around the world.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Food',
                'description' => 'Delicious recipes and food-related articles.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lifestyle',
                'description' => 'Articles about lifestyle, fashion, and personal development.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance',
                'description' => 'Insights and tips on managing personal finances and investments.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Education',
                'description' => 'Resources and articles related to education and learning.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports',
                'description' => 'News and articles about various sports and athletes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Latest news and articles on movies, music, and pop culture.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science',
                'description' => 'Exploring scientific discoveries and research.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);

        $this->command->info('Successfully seeded 10 categories!');
    }
}
