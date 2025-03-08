<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Video;
use App\Models\User;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'user_id' => User::where('role', 'tax_advisor')->inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence(3),
            'video_path' => 'https://samplelib.com/lib/preview/mp4/sample-5s.mp4', // ダミー動画URL
        ];
    }
}
