<?php

namespace Database\Factories\Domain\Song;

use App\Core\Services\Youtube\Facades\YoutubeDownload;
use App\Domain\Album\Album;
use App\Domain\Song\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SongFactory extends Factory
{
    protected $musics = [
        'https://www.youtube.com/watch?v=SSZOiq7-3mE',
        'https://www.youtube.com/watch?v=x2abvdOeZiI',
        'https://www.youtube.com/watch?v=IdWypOhjZbw',
    ];

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
        $randomMusic = $this->musics[array_rand($this->musics)];
        $musicDetails = YoutubeDownload::from($randomMusic)
            ->getInfo();

        $music = YoutubeDownload::from($randomMusic)
            ->withThumbnail(storage_path('app/public/covers'))
            ->download(storage_path('app'));

        return [
            'title' => $musicDetails->getTitle(),
            'track' => $this->faker->numberBetween(0, 3),
            'disc' => $this->faker->boolean,
            'length' => $musicDetails->getDuration(),
            'path' => $music->getFileWithExtension(),
            'mtime' => $this->faker->numberBetween(0, 10),
            'album_id' => Album::factory()->state([
                'cover' => $music->getThumbnailWithExtension(),
            ]),
        ];
    }
}
