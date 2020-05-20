<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\Topic;
use App\User;
use Faker\Generator;

class RepliesTableSeeder extends Seeder
{
    public function run()
    {
        $users_ids = User::all()->pluck('id')->toArray();
        $topic_ids = Topic::all()->pluck('id')->toArray();
        $faker = app(Generator::class);
        $replies = factory(Reply::class)->times(50)->make()->each(function ($reply, $index)
        use ($users_ids, $topic_ids, $faker) {

            $reply ->user_id = $faker->randomElement($users_ids);

            $reply->topic_id = $faker->randomElement($topic_ids);

        });

        Reply::insert($replies->toArray());
    }
}
