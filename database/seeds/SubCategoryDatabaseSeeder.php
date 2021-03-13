<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i<10 ; $i++){
        factory(Category::class, 1)->create([
            'parent_id'=> $this->getRandomParentId()
        ]);
    }}
    private function getRandomParentId(){
        return Category::inRandomOrder()->first();
    }
}
