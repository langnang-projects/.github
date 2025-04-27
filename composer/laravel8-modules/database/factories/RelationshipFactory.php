<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RelationshipFactory extends Factory
{
    protected $model = \App\Models\Relationship::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "content_id" => \App\Models\Content::inRandomOrder()->first("id"),
            "meta_id" => \App\Models\Meta::inRandomOrder()->first("id"),
            "link_id" => \App\Models\Link::inRandomOrder()->first("id"),
            "file_id" => \App\Models\File::inRandomOrder()->first("id"),
        ];
    }
}
