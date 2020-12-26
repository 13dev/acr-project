<?php

namespace Database\Factories\Domain\Album;

use App\Domain\Album\Album;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Album::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        print($this->faker->image('storage/app/public/covers', 500, 500, 'music', false));

        return [
            'name' => $this->faker->title,
            'year' => $this->faker->year,
            'genre' => $this->faker->word,
            'cover' => $this->faker->image('storage/app/public/covers', 500, 500, 'music', true),
        ];
    }
}
