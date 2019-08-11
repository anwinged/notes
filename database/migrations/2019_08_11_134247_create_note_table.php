<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNoteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
        if (!Schema::hasTable('tblCategory')) {
            Schema::create('note', static function(Blueprint $table) {
                $table->integer('id', true);
                $table->text('source');
                $table->text('html');
                $table->dateTime('createdAt');
                $table->dateTime('updatedAt');
                $table->boolean('archived');
                $table->string('title', 1024)->default('');
                $table->string('short', 1024)->default('');
            });
        }
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::drop('note');
	}

}
