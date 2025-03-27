<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'user_id', 'answer'];


    public function survey()
    {
        return $this->belongsTo(Surveys::class, 'survey_id'); // Specify the foreign key
    }
}
