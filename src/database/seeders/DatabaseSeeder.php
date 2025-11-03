<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ 固定ユーザー作成（ログイン確認用）
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // ログインパスワード固定
        ]);

        // 2️⃣ weight_logs を35件作成（ユーザーに紐づけ）
        WeightLog::factory(35)->create([
            'user_id' => $user->id,
        ]);

        // 3️⃣ weight_target を1件作成（ユーザーに紐づけ）
        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);
    }
}