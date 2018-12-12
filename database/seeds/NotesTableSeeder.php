<?php

use Illuminate\Database\Seeder;
use App\Note;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Note::class)->create([
            'value' => 20,
            'amount' => 100
        ]);

        factory(Note::class)->create([
            'value' => 50,
            'amount' => 100
        ]);

        factory(Note::class)->create([
            'value' => 100,
            'amount' => 100
        ]);

        factory(Note::class)->create([
            'value' => 500,
            'amount' => 50
        ]);

        factory(Note::class)->create([
            'value' => 1000,
            'amount' => 20
        ]);
    }
}
