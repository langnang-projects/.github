<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = \App\Models\Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            // "coid" => $this->faker->randomNumber(),
            "content_id" => $this->faker->randomNumber(),

            "text" => $this->faker->text(),

            "user_id" => \App\Models\User::inRandomOrder()->first('id'),

            "parent" => $this->model::inRandomOrder()->first('id'),

            // "created_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "updated_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "release_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "deleted_at" => $this->faker->date() . ' ' . $this->faker->time(),
        ];
    }
}
