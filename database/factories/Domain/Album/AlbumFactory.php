<?php

namespace Database\Factories\Domain\Album;

use App\Domain\Album\Album;
use App\Domain\Artist\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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
        return [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'year' => $this->faker->year,
            'genre' => $this->faker->word,
            'artist_id' => Artist::factory(),
        ];
    }
}
