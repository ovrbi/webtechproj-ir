<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    function genPlace($num)
    {
        global $place1, $place2, $places, $placepos;
        $placename = $place1[array_rand($place1)] . " " . $place2[array_rand($place2)];
        if ($places->contains($placename))
        {
            self::genPlace($num);
        }
        else
        {
            $places->add($placename);
            $pos = rand(1,31);
            for($i=0; $i<5; $i++)
            {
                if($pos&(1<<$i)>0)
                {
                    array_push($placepos[$i], $num);
                }

            }
            \App\Models\Place::create([
                'name' => $placename,
                'positions' => $pos
            ]);
        }
    }
    function genBoss()
    {
        global $boss1, $boss2, $bosses;
        $bossname = $boss1[array_rand($boss1)] . " the " . $boss2[array_rand($boss2)];
        if ($bosses->contains($bossname))
        {
            self::genBoss();
        }
        else
        {
            $bosses->add($bossname);
            \App\Models\Boss::create([
                'name' => $bossname,
                'strength' => rand(5,15),
                'health' => rand(100,1000)
            ]);
        }
    }
    function genItem()
    {
        global $item1, $item2, $items;
        $itemname = $item1[array_rand($item1)] . " of " . $item2[array_rand($item2)];
        if ($items->contains($itemname))
        {
            self::genItem();
        }
        else
        {
            $items->add($itemname);
            \App\Models\Item::create([
                'name' => $itemname,
                'strength' => rand(0,10),
                'speed' => rand(0,10),
                'endurance' => rand(0,10)
            ]);
        }
    }
    function genUser($num)
    {
        global $usernames, $emails, $mods;
        $uname = array_pop($usernames);
        $type = max(0,rand(-8,1));
        \App\Models\User::create([
            'name' => $uname,
            'email' => $uname . $emails[array_rand($emails)],
            'password' => Hash::make($uname),
            'type' => $type,
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
        
        if($type==1)
        {
            array_push($mods,$num);
        }
    }
    function genSpeedrun($num)
    {
        global $placepos, $mods;
        static $speedruns = 1;
        $hasvideo = rand(0,3)!=0;
        $confirmedby = null;
        if($hasvideo && (rand(0,3)!=0))
        {
            do
            {
                $confirmedby = $mods[array_rand($mods)];
            } while($confirmedby==$num);
        }
        $video = null;
        if ($hasvideo) $video = "https://youtu.be/" . Str::random(10);
        
        $timetotal = 0;
        $damagetotal = 0;
        for($i=0;$i<5;$i++)
        {
            $time = rand(60000,1000000);
            $bosstime = rand(60000,200000);
            $itemtime = null;
            $damage = rand(0,99);
            $bossdamage = rand(0,$damage);
        
            $placeid = $placepos[$i][array_rand($placepos[$i])];
            $bossid = rand(1,100);
        
            $itemid = null;
            if (rand(0,19)!=0)
            {
                $itemtime = rand(10000,$time) + $timetotal;
                $itemid = rand(1,100);
            }
           
            \App\Models\Segment::create([
                'order' => $i + 1,
                'starttime' => $timetotal,
                'endtime' => $timetotal+$time+$bosstime,
                'itemtime' => $itemtime,
                'damagetaken' => $damage,
                'boss_starttime' => $timetotal + $time,
                'boss_endtime' => $timetotal+$time+$bosstime,
                'boss_damagetaken' => $bossdamage,
                'item' => $itemid,
                'place' => $placeid,
                'boss' => $bossid,
                'speedrun_id' => $speedruns
            ]);

            $timetotal += $time + $bosstime;
            $damagetotal += $damage;
        }
        \App\Models\Speedrun::create([
            'timetotal' => $timetotal,
            'damagetaken' => $damagetotal,
            'video' => $video,
            'posted' => \Carbon\Carbon::today()->subDays(rand(0, 365)),
            'user_id' => $num,
            'confirmed_by' => $confirmedby
        ]);
        $speedruns++;

    }


    


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        global $usernames, $emails, $place1, $place2, $places, $boss1, $boss2, $bosses, $item1, $item2, $items, $placepos, $mods;
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
        $bosses = new \Ds\Set();
        $items = new \Ds\Set();
        $placepos = [[],[],[],[],[]];
        $mods = [];
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for ($i = 0; $i<100;$i++)
        {
            self::genPlace($i+1);
            self::genBoss();
            self::genItem();
        }



        for ($i = 0; $i<100;$i++)
        {
            self::genUser($i+1);
        }
        for ($i = 0; $i<100;$i++)
        {
            $amount = rand(0,10);
            for($j=0;$j<$amount;$j++)
            {
                self::genSpeedrun($i+1);
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
