<?php

namespace Database\Factories\Domain\Song;

use App\Domain\Album\Album;
use App\Domain\Song\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Storage;
use YoutubeDl\Options;
use YoutubeDl\YoutubeDl;

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
        $yt = new YoutubeDl();

        $collection = $yt->download(
            Options::create()
                ->downloadPath('/path/to/downloads')
                ->url('https://www.youtube.com/watch?v=oDAw7vW7H0c')
        );

        return [
            'title' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'track' => $this->faker->numberBetween(0, 3),
            'disc' => $this->faker->boolean,
            'length' => $this->faker->numberBetween(100, 1000),
            'path' => 'warden.mp3',
            'mtime' => $this->faker->numberBetween(0, 10),
            'album_id' => Album::factory(),
        ];
    }
}
