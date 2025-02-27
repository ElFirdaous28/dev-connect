<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgrammingLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            'PHP', 'JavaScript', 'Python', 'Java', 'C#', 'C++', 'Ruby', 
            'Swift', 'Go', 'Kotlin', 'Rust', 'TypeScript', 'Dart', 'Perl', 
            'Lua', 'Elixir', 'Haskell', 'Scala', 'Objective-C'
        ];

        foreach ($languages as $language) {
            DB::table('programming_languages')->insert([
                'name' => $language,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
