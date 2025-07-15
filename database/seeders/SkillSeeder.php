<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $file = File::get(public_path('json/langs.json'));
    $data = json_decode($file, true);

    if (is_array($data)) {
      collect($data)->chunk(500)->each(function ($chunk) {
        foreach ($chunk as $skill) {
          Skill::create([
            'name' => $skill,
            'category_id' => 2
          ]);
        }
      });
    }

    // if ($file) {
    //     $lines = explode("\n", $file);
    //     foreach ($lines as $line) {
    //         $line = trim($line, "\" \t\n\r\0\x0B,");
    //         if ($line !== '') {
    //             echo "\"$line\"\n,\n";
    //         }
    //     }
    // }
  }
}
