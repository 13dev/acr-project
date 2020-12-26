<?php

namespace Database\Factories\Domain\Song;

use App\Domain\Album\Album;
use App\Domain\Song\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Storage;

class SongFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Song::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' =>  $this->faker->firstName . ' ' . $this->faker->lastName,
            'track' => $this->faker->numberBetween(0, 3),
            'disc' => $this->faker->boolean,
            'length' => $this->faker->numberBetween(0, 10),
            'path' => 'warden.mp3',
            'mtime' => $this->faker->numberBetween(0, 10),
            'album_id' => Album::factory(),
        ];
    }
}
