<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    function genPlace()
    {
        global $place1, $place2, $places;
        $placename = $place1[array_rand($place1)] . " " . $place2[array_rand($place2)];
        if ($places->contains($placename))
        {
            self::genPlace();
        }
        else
        {
            \Log::info($placename);
            $places->add($placename);
            \App\Models\Place::create([
                'name' => $placename,
                'positions' => rand(1,31)
            ]);
        }
    }
    function genBoss()
    {
        global $boss1, $boss2;
    }
    function genItem()
    {
        global $item1, $item2;
    }
    function genUser($num)
    {
        global $usernames, $emails;
        $uname = array_pop($usernames);
        \App\Models\User::create([
            'name' => $uname,
            'email' => $uname . $emails[array_rand($emails)],
            'password' => Hash::make($uname),
            'type' => 0
        ]);
        $amount = rand(0,10);
        for($i=0;$i<$amount;$i++)
        {
            self::genSpeedrun($num);
        }
    }
    function genSpeedrun($num)
    {

    }


    


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        global $usernames, $emails, $place1, $place2, $places, $boss1, $boss2, $item1, $item2;
        srand(1);
        $usernames = file(storage_path() . '\files\usernames.txt', FILE_IGNORE_NEW_LINES);
        shuffle($usernames);
        $emails = ["@gmail.com","@yahoo.com","@hotmail.com","@inbox.lv","@edu.lu.lv","@sets.lv","@outlook.com"];
        $place1 = file(storage_path() . '\files\place1.txt', FILE_IGNORE_NEW_LINES);
        $place2 = file(storage_path() . '\files\place2.txt', FILE_IGNORE_NEW_LINES);
        $boss1 = file(storage_path() . '\files\boss1.txt', FILE_IGNORE_NEW_LINES);
        $boss2 = file(storage_path() . '\files\boss2.txt', FILE_IGNORE_NEW_LINES);
        $item1 = file(storage_path() . '\files\item1.txt', FILE_IGNORE_NEW_LINES);
        $item2 = file(storage_path() . '\files\item2.txt', FILE_IGNORE_NEW_LINES);
        $places = new \Ds\Set();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for ($i = 0; $i<100;$i++)
        {
            self::genPlace();
            self::genBoss();
            self::genItem();
        }



        for ($i = 0; $i<100;$i++)
        {
            self::genUser($i);
        }
    }
}
