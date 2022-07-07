<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'description'=>$this->faker->text(20),
            'image'=>$this->faker->image('public/uploads/images', 600, 400, null, false) ,
            'price'=>rand(200, 5000),
            'category_id'=>rand(1,3),
            'quantity'=>rand(2,5)
        ];
    }
}
