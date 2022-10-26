<?php

namespace Database\Seeders;

use App\Enums\AdminRole;
use App\Enums\UserRole;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$password = Hash::make('password');

		User::create([
			'name' => 'Mahendra Wardana',
			'username' => 'wardana_m',
			'email' => 'admin20@mail.test',
			'password' => $password,
			'role' => UserRole::OWNER,
		]);

		User::create([
			'name' => 'Adi Aryasuta',
			'username' => 'aryasuta_a',
			'email' => 'admin21@mail.test',
			'password' => $password,
			'role' => UserRole::ADMIN,
		]);

		User::create([
			'name' => 'Wahyu Pranata',
			'username' => 'pranata_w',
			'email' => 'admin22@mail.test',
			'password' => $password,
			'role' => UserRole::ADMIN,
		]);

		User::create([
			'name' => 'Wisnu Sanjaya',
			'username' => 'sanjaya_w',
			'email' => 'admin23@mail.test',
			'password' => $password,
			'role' => UserRole::NORMAL,
		]);

		User::create([
			'name' => 'Pramanta Dharma',
			'username' => 'dharma_p',
			'email' => 'admin24@mail.test',
			'password' => $password,
			'role' => UserRole::NORMAL,
		]);
	}
}
