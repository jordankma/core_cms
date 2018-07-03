<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dhcd_member')->insert([
        	'token' => 'asdashdiQAWrihoaiw23qwke2asd',
        	'u_name' => 'tuanlv1',
        	'password' => bcrypt('123456'),
        	'avatar' => 'tet.png',
        	'address' => 'ha noi',
        	'birthday' => new DateTime(),
        	'reg_ip' => '22.2.2.2',
        	'last_login' => new DateTime(),
        	'last_ip' => new DateTime(),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_member')->insert([
        	'token' => 'asdashdiQAWrihoaiw23qwke2asd',
        	'u_name' => 'tuanlv2',
        	'password' => bcrypt('123456'),
        	'avatar' => 'tet.png',
        	'address' => 'ha noi',
        	'birthday' => new DateTime(),
        	'reg_ip' => '22.2.2.2',
        	'last_login' => new DateTime(),
        	'last_ip' => new DateTime(),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('dhcd_member')->insert([
        	'token' => 'asdashdiQAWrihoaiw23qwke2asd',
        	'u_name' => 'tuanlv3',
        	'password' => bcrypt('123456'),
        	'avatar' => 'tet.png',
        	'address' => 'ha noi',
        	'birthday' => new DateTime(),
        	'reg_ip' => '22.2.2.2',
        	'last_login' => new DateTime(),
        	'last_ip' => new DateTime(),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
