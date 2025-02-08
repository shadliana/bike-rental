<?php

namespace Database\Factories;

use App\Models\Bike;
use Illuminate\Database\Eloquent\Factories\Factory;

class BikeFactory extends Factory
{
    protected $model = Bike::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,  // تولید یک کلمه تصادفی برای نام
            'status' => $this->faker->randomElement(['available', 'reserved']),  // وضعیت تصادفی
        ];
    }
}
