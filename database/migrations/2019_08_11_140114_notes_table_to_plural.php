<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class NotesTableToPlural extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('note', 'notes');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::rename('notes', 'note');
    }
}
