<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->toArray());

        $user = User::find(1);
        $user->name = 'zz';
        $user->email = 'zz@zz.com';
        $user->password = bcrypt('zz');
        $user->is_admin = true;
        $user->activated = true;
        $user->save();
    }
}
