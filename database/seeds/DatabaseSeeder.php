<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //creates participants if needed
//      $participants=  factory(App\Participant::class, 50)->create();

        // Populate users
        $data = array(
            array(
                'name'   =>   'Concert',
                'event_date' => '2021-03-01 12:00:00',
                'place' => 'Moscow'
            ),
            array(
                'name'   =>   'Exhibition',
                'event_date' => '2021-04-01 12:00:00',
                'place' => 'St. Petersburg'
            ),
            array(
                'name'   =>   'Theater',
                'event_date' => '2021-05-01 12:00:00',
                'place' => 'Saratov'
            ),
            array(
                'name'   =>   'Festival',
                'event_date' => '2021-06-01 12:00:00',
                'place' => 'Paris'
            )
        );

        DB::table('events')->insert($data);

        // Get all the events 
//        $events = \App\Event::all();
        // create attaches if needed
//        App\Participant::all()->each(function ($participants) use ($events) {
//            $participants->events()->attach(
//                $events->random(rand(1, 4)->pluck('id')->toArray()
//            );
//        });
    }
}
