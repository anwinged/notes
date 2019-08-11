<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use DatabaseTransactions;

    public function testAllNotes(): void
    {
        factory(Note::class, 10)->create();

        $response = $this->get('/api/notes');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }
}
