<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyLanguage extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id','lang','name', 'question', 'is_active'];

    protected $table = 'survey_language';
}
