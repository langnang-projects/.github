<?php
namespace Modules\Home\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HomeContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Home\Models\HomeContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            "title" => \Str::random(10)
        ];
    }
}