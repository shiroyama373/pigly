<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCalorieAndExerciseToWeightLogsTable extends Migration
{
    public function up(): void
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->integer('calorie')->nullable()->after('weight');   // カロリー
            $table->integer('exercise')->nullable()->after('calorie'); // 運動時間
        });
    }

    public function down(): void
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->dropColumn(['calorie', 'exercise']);
        });
    }
}