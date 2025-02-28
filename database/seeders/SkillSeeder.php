<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // You can add a list of skills here to populate the table
        $skills = [
            'PHP',
            'JavaScript',
            'Laravel',
            'Vue.js',
            'React',
            'CSS',
            'HTML',
            'MySQL',
            'Node.js',
            'Python',
        ];

        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill,
            ]);
        }
    }
}
