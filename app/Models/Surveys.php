<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'question', 'is_active'];


    protected  $appends = ['total_votes'];


    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'survey_id');
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }


    public function responses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'survey_id');
    }
}
