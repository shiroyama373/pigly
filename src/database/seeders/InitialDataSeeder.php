<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightTarget;
use App\Models\WeightLog;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // 1名のユーザーを作成
        $user = User::factory()->create();

        // WeightTarget を1件作成（ユーザーに紐づけ）
        WeightTarget::factory()->for($user)->create();

        // WeightLog を35件作成（ユーザーに紐づけ）
        WeightLog::factory()->for($user)->count(35)->create();
    }
}