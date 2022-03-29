<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rating = new Rating();
        $rating->number_star = 1;
        $rating->save();

        $rating1 = new Rating();
        $rating1->number_star = 2;
        $rating1->save();

        $rating2 = new Rating();
        $rating2->number_star = 3;
        $rating2->save();

        $rating3 = new Rating();
        $rating3->number_star = 4;
        $rating3->save();

//        $rating4 = new Rating();
//        $rating4->number_star = 5;
//        $rating4->save();
    }
}
