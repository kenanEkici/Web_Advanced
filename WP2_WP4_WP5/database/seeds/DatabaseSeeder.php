<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        // call our class and run our seeds
        $this->call('appSeeder');
        $this->command->info('seeds finished.');
    }
}

class appSeeder extends Seeder
{

    //php artisan migrate:refresh --seed
    //to seed and migrate (delete all db columns first)

    //or

    //php artisan migrate
    //php artisan db:seed

    public function run()
    {
        DB::table('users')->delete();
        DB::table('events')->delete();
        DB::table('users_events')->delete();


        $CEO = User::create(array('username' =>'Mister_CEO', 'hash' => 'pass',
            'first_name' => 'Mister', 'last_name' => 'CEO', 'role' => 'CEO', 'address'=>'Hasselt'));
        $Cameraman = User::create(array('username' =>'CameraGuy', 'hash' => 'pass',
            'first_name' => 'Camera', 'last_name' => 'Guy', 'role' => 'intern_employee', 'address'=>'Heusden'));

        $Meeting = Event::create(array('start_date' => date_create("2017-07-20 16:20:00"), 'organiser' =>$CEO->first_name ." ". $CEO->last_name, 'title' => 'Meeting',
            'description' => 'Voor alle werknemers', 'end_date' => date_create("2017-07-20 20:00:00"),'location' => "Hasselt", 'invited'=>''));

        $CEO->events()->attach($Meeting);
        $Cameraman->events()->attach($Meeting);
    }
}
