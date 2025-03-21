<?php

namespace App\Repositories\Admin;

use App\Models\EmailTemplate;
use App\Models\EmailTemplateLanguage;
use App\Repositories\Interfaces\Admin\EmailTemplateLanguageInterface;

class EmailTemplateLanguageRepository implements EmailTemplateLanguageInterface {

    public function find($id)
    {
        return EmailTemplateLanguage::find($id);
    }

    public function store($request)
    {
        $request = $request->all();
        return EmailTemplateLanguage::create($request);
    }

    public function update($request)
    {
        $request = $request->all();
        $slider = EmailTemplateLanguage::find($request['translate_id']);
        $slider->update($request);
        return $slider;
    }
}
