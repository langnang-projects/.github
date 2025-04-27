<?php
namespace Modules\WebNav\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebNavFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\WebNav\Models\WebNav::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            "slug" => $this->faker->slug(),
            "ico" => $this->faker->imageUrl(72, 72),

            "title" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "text" => '<!--markdown-->\r\n' . $this->faker->text() . '<!--more-->\r\n',
            "type" => $this->faker->randomElement(['draft-post', 'post', 'draft-page', 'page', 'draft-template', 'template', 'draft-collection', 'collection']),
            "status" => $this->faker->randomElement(['public', 'publish', 'protect', 'private']),

            "views" => $this->faker->randomNumber(),
            "count" => $this->faker->randomNumber(),
            "order" => $this->faker->randomNumber(),
            "parent" => $this->model::inRandomOrder()->first('id'),
        ];
    }
}

