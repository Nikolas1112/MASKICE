<?php

namespace App\Repositories\Admin;

use App\Models\SurveyLanguage;
use App\Repositories\Interfaces\Admin\SurveysLanguageInterface;

class SurveyLanguageRepository implements SurveysLanguageInterface
{
    public function find($id)
    {
        return SurveyLanguage::find($id);
    }

    public function store($request)
    {
        $request = $request->all();
        return SurveyLanguage::create($request);
    }

    public function update($request)
    {
        $request = $request->all();
        $slider = SurveyLanguage::find($request['translate_id']);
        $slider->update($request);
        return $slider;
    }
}