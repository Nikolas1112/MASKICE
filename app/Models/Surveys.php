<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'question', 'is_active'];

    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class, 'survey_id'); // Assuming 'survey_id' is the foreign key in SurveyResponse
    }
}
