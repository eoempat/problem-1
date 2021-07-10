<?php

namespace Database\Seeders;

use App\Models\{
    Category,
    Post,
    Tag
};

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect([]);

        for($i = 0; $i < 10; ++$i) {
            $tag = new Tag;

            $tag->name = 'Tag ' . ($i+1);
            $tag->save();

            $tags->push($tag);
        }

        for($i = 0; $i < 10; ++$i) {
            $category = new Category;

            $category->name = 'Category ' . ($i+1);
            $category->save();

            $totalPosts = rand(1, 10);

            for($j = 0; $j < $totalPosts; ++$j) {
                $post = new Post;

                $post->title = 'Post ' . ($j+1);
                $post->category_id = $category->id;

                $post->save();

                $totalTags = rand(1, 10);
                $randomTags = array_rand(range(1, 10), $totalTags);
                
                $tagsToAttach = $tags->filter(function($tag, $key) use ($randomTags){
                    return in_array($key, is_array($randomTags) ? $randomTags : [$randomTags]);
                })->pluck('id')->values()->toArray();

                $post->tags()->attach($tagsToAttach);
            }
        }
    }
}
