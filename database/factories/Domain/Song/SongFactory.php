<?php

namespace Database\Factories\Domain\Song;

use App\Domain\Album\Album;
use App\Domain\Song\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = $this->faker->title;

        return [
            'title' => $title,
            'track' => $this->faker->title,
            'disc' => $this->faker->boolean,
            'length' => $this->faker->numberBetween(0, 10),
            'path' => Str::slug($title).'.mp3',
            'mtime' => $this->faker->numberBetween(0, 10),
        ];
    }
}
