<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Note;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use DatabaseMigrations;

    public function testAllNotes(): void
    {
        factory(Note::class, 10)->create();

        $response = $this->get('/api/notes');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }
}
