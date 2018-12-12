<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery as m;
use App\Repos\NoteRepository;
use App\Note;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @test
     * @covers ::getDeductNotes
     * @dataProvider correctNotesData
     *
     * @param $notes
     * @param $withdrawAmount
     * @param $expectedNotes
     */
    public function it_should_return_correct_notes($notes, $withdrawAmount, $expectedNotes)
    {
        $this->note
            ->shouldReceive('orderBy')
            ->with('value', 'desc')
            ->andReturnSelf()
            ->shouldReceive('get')
            ->andReturn($notes);

        $return = $this->noteRepo->getDeductNotes($withdrawAmount);

        $this->assertEquals($expectedNotes, $return);
    }

    /**
     * @return array
     */
    public function correctNotesData()
    {
        $notes1 = new Collection([
            new Note(['value' => 1000, 'amount' => 0]),
            new Note(['value' => 500, 'amount' => 2]),
            new Note(['value' => 50, 'amount' => 100]),
        ]);
        $notes2 = new Collection([
            new Note(['value' => 50, 'amount' => 2]),
            new Note(['value' => 20, 'amount' => 100]),
        ]);

        $expectedNote1 = [
            ['id' => null, 'note' => 500, 'deduct' => 2],
            ['id' => null, 'note' => 50, 'deduct' => 10],
        ];

        $expectedNote2 = [
            ['id' => null, 'note' => 50, 'deduct' => 2],
            ['id' => null, 'note' => 20, 'deduct' => 10],
        ];

        return [
            [$notes1, 1500, $expectedNote1],
            [$notes2, 300, $expectedNote2],
        ];
    }
}
