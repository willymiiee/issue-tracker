<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        $categories = [
            'To Do',
            'In Progress',
            'Review',
            'Done'
        ];

        foreach ($categories as $c) {
            DB::table('categories')->insert([
                'name' => $c,
                'created_at' => Carbon::now()
            ]);
        }
    }
}
