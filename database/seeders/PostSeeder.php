<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing category IDs and names
        $categories = DB::table('categories')->pluck('name', 'id')->toArray();

        if (empty($categories)) {
            $this->command->error('No categories found! Run CategorySeeder first.');
            return;
        }

        // Initial posts with specific content matched to categories
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a web application framework with expressive, elegant syntax.',
                'user_id' => 1,
                'category_id' => $this->findCategoryId($categories, 'Technology'),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10)
            ],
            [
                'title' => 'The Art of Writing Clean Code',
                'content' => 'Clean code is code that is easy to understand and easy to change.',
                'user_id' => 2,
                'category_id' => $this->findCategoryId($categories, 'Technology'),
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8)
            ],
            [
                'title' => 'Healthy Eating Habits',
                'content' => 'Discover how simple dietary changes can improve your overall health.',
                'user_id' => 1,
                'category_id' => $this->findCategoryId($categories, 'Health'),
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6)
            ],
            [
                'title' => 'Top 10 Travel Destinations for 2023',
                'content' => 'Explore these amazing destinations for your next vacation.',
                'user_id' => 3,
                'category_id' => $this->findCategoryId($categories, 'Travel'),
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4)
            ],
            [
                'title' => 'Easy Weeknight Dinner Recipes',
                'content' => 'Quick and delicious recipes for busy weeknights.',
                'user_id' => 2,
                'category_id' => $this->findCategoryId($categories, 'Food'),
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ]
        ];

        // Generate 15 more varied posts matching categories
        $categoryPosts = [
            'Technology' => [
                'Understanding MVC Architecture',
                'Building RESTful APIs',
                'Cloud Computing Basics'
            ],
            'Health' => [
                'Meditation Techniques',
                'Sleep Optimization',
                'Workout Routines'
            ],
            'Travel' => [
                'Budget Travel Tips',
                'Family Vacation Ideas',
                'Best Beaches in Asia'
            ],
            'Food' => [
                'Baking Tips and Tricks',
                'Vegetarian Meal Prep',
                'Cocktail Recipes'
            ],
            'Finance' => [
                'Investment Strategies',
                'Saving Money Tips',
                'Side Hustle Ideas'
            ],
            'Science' => [
                'Latest Space Discoveries',
                'Climate Change Research'
            ]
        ];

        foreach ($categoryPosts as $categoryName => $titles) {
            foreach ($titles as $title) {
                $posts[] = [
                    'title' => $title,
                    'content' => $this->generateLoremContent($title),
                    'user_id' => rand(1, 10),
                    'category_id' => $this->findCategoryId($categories, $categoryName),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 30))
                ];
            }
        }

        DB::table('posts')->insert($posts);

        $this->command->info('Successfully seeded ' . count($posts) . ' posts with category-matched data!');
    }

    /**
     * Helper method to find category ID by name
     */
    private function findCategoryId(array $categories, string $name): ?int
    {
        foreach ($categories as $id => $categoryName) {
            if (strtolower($categoryName) === strtolower($name)) {
                return $id;
            }
        }
        return null;
    }

    /**
     * Generate relevant lorem ipsum content
     */
    private function generateLoremContent(string $title): string
    {
        $base = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. This will now switch to relevant content based on the it's relevant categories: ";
        $keywords = explode(' ', strtolower($title));

        if (in_array('technology', $keywords)) {
            $base .= "This technical article explores modern solutions for developers. ";
        } elseif (in_array('health', $keywords)) {
            $base .= "This health-related content provides valuable wellness insights. ";
        } elseif (in_array('travel', $keywords)) {
            $base .= "Perfect for travelers seeking new adventures and experiences. ";
        }

        return $base . Str::random(200);
    }
}
