<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:order {--seed}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Execute the migrations in the order specified in the file app/Console/Commands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$migrations = [
			'2022_10_04_110536_create_users_table.php',
			'2022_09_02_084320_create_blogs_table.php',
			'2022_09_28_002110_create_categories_table.php',
			'2022_09_28_004134_create_blog_category_table.php',
			'2022_09_11_084139_create_similar_blogs_table.php',
			'2022_09_28_002455_create_viewed_blogs_table.php',
		];

		foreach ($migrations as $migration) {
			$basePath = 'database/migrations/';

			$migrationName = trim($migration);

			$path = $basePath . $migrationName;

			$this->call('migrate:refresh', ['--path' => $path]);
		}

		if ($this->option('seed'))
			$this->call('db:seed');

		return 0;
	}
}
