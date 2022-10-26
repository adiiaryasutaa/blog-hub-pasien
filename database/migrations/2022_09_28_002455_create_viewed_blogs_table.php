<?php

use App\Models\Blog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('viewed_blogs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('blog_id')->constrained()->cascadeOnDelete();
			$table->timestamp('viewed_at')->useCurrent();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('viewed_blogs');
	}
};
