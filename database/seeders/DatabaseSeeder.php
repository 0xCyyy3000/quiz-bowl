<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Mode;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Contestant;
use App\Models\QuestionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Mode::create(['mode' => 'Easy']);
        Mode::create(['mode' => 'Moderate']);
        Mode::create(['mode' => 'Difficult']);

        Category::create(['category' => 'General Education']);
        Category::create(['category' => 'Information Technology']);
        Category::create(['category' => 'Business Administration']);

        QuestionType::create(['type' => 'Multiple Choices']);
        QuestionType::create(['type' => 'True or False']);

        Question::create([
            'category_id'       => 2,
            'question_type'     => 2,
            'question'         => 'Alan Turing is known as "The Father of Computer Science".',
            'choices'           => json_encode(['true' => true, 'false' => false]),
            'correct_answer'   => 'true',
            'mode'              => 2
        ]);

        Question::create([
            'category_id'       => 1,
            'question_type'     => 1,
            'question'         => 'What Netflix show had the most streaming views in 2021?',
            'choices'           => json_encode([
                'a' => 'Fate: The Wingx Saga',
                'b' => 'Squid Game',
                'c' => 'Pacific Rim: The Black',
                'd' => 'The One and Only',
            ]),
            'correct_answer'   => 'b',
            'mode'              => 1
        ]);

        Question::create([
            'category_id'       => 1,
            'question_type'     => 1,
            'question'         => 'Which of the following is the what? Lol 😛',
            'choices'           => json_encode([
                'a' => 'Secret po',
                'b' => 'Shesh',
                'c' => 'Chill la kita',
                'd' => 'Eyyyy',
            ]),
            'correct_answer'   => 'd',
            'mode'              => 1
        ]);

        User::create([
            'name' => 'cy pogi',
            'email' => 'cy@pogi.com',
            'password' => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name' => 'Team Chaka',
            'email' => 'one@team.com',
            'password' => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name' => 'Team Pogi',
            'email' => 'two@team.com',
            'password' => Hash::make('asdfasdf'),
        ]);

        Contestant::create([
            'name'      => 'Team Chaka',
            'status'    => true,
            'code'      => '0x123',
            'user_id'   => 1
        ]);

        Contestant::create([
            'name'      => 'Team Pogi',
            'status'    => true,
            'code'      => '0x321',
            'user_id'   => 2
        ]);
    }
}
