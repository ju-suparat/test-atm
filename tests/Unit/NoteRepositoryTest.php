<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;
use App\Repos\NoteRepository;
use App\Note;

/**
 * @coversDefaultClass \App\Repos\NoteRepository
 */
class NoteRepositoryTest extends TestCase
{
    protected $note;
    protected $noteRepo;

    public function setUp()
    {
        parent::setUp();

        $this->note     = m::mock(Note::class);
        $this->noteRepo = new NoteRepository($this->note);
    }

    /**
     * @test
     * @covers ::find
     */
    public function it_can_find_by_id()
    {
        $note     = new Note();
        $note->id = 1;

        $this->note
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($note);

        $this->noteRepo->find(1);
    }

    /**
     * @test
     * @covers ::findAmount
     */
    public function it_should_find_amount()
    {
        $note         = new Note();
        $note->id     = 1;
        $note->amount = $this->faker->randomDigit;

        $amount = $this->noteRepo->findAmount($note);

        $this->assertEquals($note->amount, $amount);
    }
}
