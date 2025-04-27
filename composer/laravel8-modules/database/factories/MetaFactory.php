<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MetaFactory extends Factory
{
    protected $model = \App\Models\Meta::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $typeOptions = \App\Models\Option::where('name', 'meta.type')->first()->toArray()['value'];
        if (empty($typeOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.type')->first()->toArray()['value'];
        }
        $statusOptions = \App\Models\Option::where('name', 'meta.status')->first()->toArray()['value'];
        if (empty($statusOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.status')->first()->toArray()['value'];
        }
        return [
            // "mid" => $this->faker->randomNumber(),
            "slug" => $this->faker->slug(),
            //
            "name" => $this->faker->sentence(),
            "ico" => $this->faker->imageUrl(72, 72),
            "description" => $this->faker->sentence(),
            "type" => $this->faker->randomElement(array_keys($typeOptions)),
            "status" => $this->faker->randomElement(array_keys($statusOptions)),

            "count" => $this->faker->randomNumber(),
            "order" => $this->faker->randomNumber(),
            "parent" => $this->faker->randomElement([0, $this->model::inRandomOrder()->first('id')]),

            "user_id" => \App\Models\User::inRandomOrder()->first('id'),

            // "created_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "updated_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "release_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "deleted_at" => $this->faker->date() . ' ' . $this->faker->time(),
        ];
    }
}
