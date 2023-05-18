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
        QuestionType::create(['type' => 'Identification']);
        QuestionType::create(['type' => 'True or False']);

        Question::create([
            'category_id'       => 2,
            'type_id'           => 3,
            'question'          => 'Alan Turing is known as "The Father of Computer Science".',
            'choices'           => json_encode(['true' => true, 'false' => false]),
            'correct_answer'    => 'true',
            'mode_id'           => 2
        ]);

        Question::create([
            'category_id'       => 2,
            'type_id'           => 2,
            'question'          => 'What is the largest constellation?',
            'choices'           => json_encode(''),
            'correct_answer'    => 'Hydra',
            'mode_id'           => 3
        ]);

        Question::create([
            'category_id'       => 1,
            'type_id'           => 1,
            'question'          => 'What Netflix show had the most streaming views in 2021?',
            'choices'           => json_encode([
                'a' => 'Fate: The Wingx Saga',
                'b' => 'Squid Game',
                'c' => 'Pacific Rim: The Black',
                'd' => 'The One and Only',
            ]),
            'correct_answer'   => 'b',
            'mode_id'          => 1
        ]);

        Question::create([
            'category_id'       => 1,
            'type_id'           => 1,
            'question'          => 'Which of the following is the what? Lol 😛',
            'choices'           => json_encode([
                'a' => 'Secret po',
                'b' => 'Shesh',
                'c' => 'Chill la kita',
                'd' => 'Eyyyy',
            ]),
            'correct_answer'   => 'd',
            'mode_id'          => 1
        ]);

        User::create([
            'name'      => 'cy pogi',
            'email'     => 'cy@pogi.com',
            'password'  => Hash::make('asdfasdf'),
            'role'      => 100
        ]);

        User::create([
            'name'      => 'Team 1',
            'email'     => 'one@team.com',
            'password'  => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name'      => 'Team 2',
            'email'     => 'two@team.com',
            'password'  => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name'      => 'Team 3',
            'email'     => 'three@team.com',
            'password'  => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name'      => 'Team 4',
            'email'     => 'four@team.com',
            'password'  => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name' => 'Team 5',
            'email' => 'five@team.com',
            'password' => Hash::make('asdfasdf'),
        ]);

        User::create([
            'name'      => 'Team 6',
            'email'     => 'six@team.com',
            'password'  => Hash::make('asdfasdf'),
        ]);

        Contestant::create(['user_id'   => 2]);
        Contestant::create(['user_id'   => 3]);
        Contestant::create(['user_id'   => 4]);
        Contestant::create(['user_id'   => 5]);
        Contestant::create(['user_id'   => 6]);
        Contestant::create(['user_id'   => 7]);
    }
}
