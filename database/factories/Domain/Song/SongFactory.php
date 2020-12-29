<?php

namespace Database\Factories\Domain\Song;

use App\Core\Services\Youtube\Facades\YoutubeDownload;
use App\Domain\Album\Album;
use App\Domain\Song\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    protected $musics = [
        'https://www.youtube.com/watch?v=SSZOiq7-3mE',
        'https://www.youtube.com/watch?v=x2abvdOeZiI',
        'https://www.youtube.com/watch?v=IdWypOhjZbw',
        'https://www.youtube.com/watch?v=x2abvdOeZiI',
        'https://www.youtube.com/watch?v=IdWypOhjZbw',
        'https://www.youtube.com/watch?v=APqnjoQ43_A',
        'https://www.youtube.com/watch?v=UYK8OlcjdcM',
        'https://www.youtube.com/watch?v=TjULkVkfsgI',
        'https://www.youtube.com/watch?v=1qR0lnzt3hI',
        'https://www.youtube.com/watch?v=znQsetWNfLc',
        'https://www.youtube.com/watch?v=WsfVs1T11mA',
        'https://www.youtube.com/watch?v=FapZ71hDrCA',
        'https://www.youtube.com/watch?v=u5topaKIwls',
        'https://www.youtube.com/watch?v=jt5ail2MMPM',
        'https://www.youtube.com/watch?v=YTflpScoj8U',
        'https://www.youtube.com/watch?v=MdmKVo-UqYw',
        'https://www.youtube.com/watch?v=NMs-DCbRQA0',
        'https://www.youtube.com/watch?v=DiBMrQFF_3Y',
        'https://www.youtube.com/watch?v=nJ1IckW3Gi4',
        'https://www.youtube.com/watch?v=FJqJ8VHYO78',
        'https://www.youtube.com/watch?v=YLht-x2EtdU',
        'https://www.youtube.com/watch?v=WZwIDabWE5w',
        'https://www.youtube.com/watch?v=Sutwk8T5vQY',
        'https://www.youtube.com/watch?v=lurrMwQ2kGc',
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
            ->thumbnail()
            ->download(storage_path('app'));

        return [
            'title' => $musicDetails->getTitle(),
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
