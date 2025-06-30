<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'Laravel',
                'description' => 'A PHP framework for web artisans.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PHP',
                'description' => 'A popular general-purpose scripting language.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'JavaScript',
                'description' => 'A programming language for the web.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HTML',
                'description' => 'The standard markup language for creating web pages.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CSS',
                'description' => 'A style sheet language used for describing the presentation of a document.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MySQL',
                'description' => 'An open-source relational database management system.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'API',
                'description' => 'A set of routines, protocols, and tools for building software and applications.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Web Development',
                'description' => 'The work involved in developing a website for the Internet.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Software Engineering',
                'description' => 'The application of engineering principles to software development.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DevOps',
                'description' => 'A set of practices that combines software development and IT operations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tags')->insert($tags);

        $this->command->info('Successfully seeded 10 tags!');
    }
}
