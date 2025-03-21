<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplateLanguage extends Model
{
    use HasFactory;

    protected $fillable = ['email_template_id','lang','name', 'type', 'subject', 'description'];

    protected $table = 'email_template_language';
}
