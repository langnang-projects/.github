<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    protected $model = \App\Models\Link::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $typeOptions = \App\Models\Option::where('name', 'link.type')->first()->toArray()['value'];
        if (empty($typeOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.type')->first()->toArray()['value'];
        }
        $statusOptions = \App\Models\Option::where('name', 'link.status')->first()->toArray()['value'];
        if (empty($statusOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.status')->first()->toArray()['value'];
        }
        return [
            // "lid" => $this->faker->randomNumber(),
            "slug" => $this->faker->slug(),
            //
            "title" => $this->faker->sentence(),
            "ico" => $this->faker->imageUrl(72, 72),
            "url" => $this->faker->url(),
            "keywords" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "type" => $this->faker->randomElement(array_keys($typeOptions)),
            "status" => $this->faker->randomElement(array_keys($statusOptions)),

            "count" => $this->faker->randomNumber(),
            "order" => $this->faker->randomNumber(),
            "parent" => $this->model::inRandomOrder()->first('id'),

            "user_id" => \App\Models\User::inRandomOrder()->first('id') ?? 0,

            // "created_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "updated_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "release_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "deleted_at" => $this->faker->date() . ' ' . $this->faker->time(),
        ];
    }
}
