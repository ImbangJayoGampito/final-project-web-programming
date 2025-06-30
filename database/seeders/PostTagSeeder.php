<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all posts and tags
        $posts = DB::table('posts')->pluck('id');
        $tags = DB::table('tags')->pluck('id');

        if ($posts->isEmpty() || $tags->isEmpty()) {
            $this->command->error('No posts or tags found! Please seed posts and tags first.');
            return;
        }

        $records = [];

        // For each post, assign 2-4 random tags
        foreach ($posts as $postId) {
            $assignedTags = [];
            $tagsToAssign = min(rand(2, 4), $tags->count());

            while (count($assignedTags) < $tagsToAssign) {
                $tagId = $tags->random();

                // Ensure we don't assign the same tag twice to the same post
                if (!in_array($tagId, $assignedTags)) {
                    $assignedTags[] = $tagId;

                    $records[] = [
                        'tag_id' => $tagId,
                        'post_id' => $postId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        DB::table('tags_posts')->insert($records);

        $this->command->info('Successfully seeded post-tag relationships!');
        $this->command->info('Assigned tags to ' . count($posts) . ' posts.');
    }
}
