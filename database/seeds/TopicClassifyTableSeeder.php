<?php

use Illuminate\Database\Seeder;

class TopicClassifyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topic_classify')->insert([
            'name' => '教程',
        ]);
        DB::table('topic_classify')->insert([
            'name' => '分享',
        ]);
        DB::table('topic_classify')->insert([
            'name' => '问答',
        ]);
        DB::table('topic_classify')->insert([
            'name' => '招聘',
        ]);
    }
}
