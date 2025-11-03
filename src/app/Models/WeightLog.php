<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    use HasFactory;

    // 保存可能なカラム
    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'calorie',        // ← DBに合わせる
        'exercise',       // ← DBに合わせる
        'exercise_time',
        'exercise_content',
    ];

    // 日付カラムを自動で Carbon に変換＆フォーマット指定
    protected $casts = [
        'date' => 'datetime:Y-m-d',  // 取得時やJSON出力時にY-m-d形式
    ];

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}