<?php

use Illuminate\Database\Seeder;
use Laratube\User;
use Laratube\Channel;
use Laratube\Subscription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $user1 = factory(User::class)->create([
            'email' => 'john@doe.io'
        ]);
        $user2 = factory(User::class)->create([
            'email' => 'jane@doe.io'
        ]);

        $channel1 = factory(Channel::class)->create([
            'user_id' => $user1->id,
        ]);
        $channel2 = factory(Channel::class)->create([
            'user_id' => $user2->id,
        ]);

        // 2 users subscribe across each other channel
        $channel1->subscriptions()->create([
            'user_id' => $user2->id,
        ]);
        $channel2->subscriptions()->create([
            'user_id' => $user1->id,
        ]);

        // Tạo 1 lượng subscribers khổng lồ cho 2 channels trên
        factory(Subscription::class, 100)->create([
            'channel_id' => $channel1->id,
        ]);
        factory(Subscription::class, 100)->create([
            'channel_id' => $channel2->id,
        ]);

        // Video & comments
        $video = factory(\Laratube\Video::class)->create([
            'channel_id' => $channel1->id,
        ]);
        factory(\Laratube\Comment::class, 10)->create([
            'video_id' => $video->id
        ]);
        // comment's replies
        $firstComment = \Laratube\Comment::first();
        factory(\Laratube\Comment::class, 5)->create([
            'video_id' => $video->id,
            'comment_id' => $firstComment->id
        ]);

    }
}
