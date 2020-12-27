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
        $imageName = Str::random(20).'.jpg';
        file_put_contents(
            storage_path('app/public/covers/'. $imageName),
            file_get_contents('http://placeimg.com/640/480/people')
        );
        return [
            'name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'year' => $this->faker->year,
            'genre' => $this->faker->word,
            'cover' => $imageName,
            'artist_id' => Artist::factory(),
        ];
    }
}
