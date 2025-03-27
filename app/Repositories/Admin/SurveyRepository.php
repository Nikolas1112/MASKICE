<?php

namespace App\Repositories\Admin;

use App\Models\Surveys;
use App\Models\SurveyLanguage;
use App\Repositories\Admin\Service\ServiceLangRepository;
use App\Repositories\Interfaces\Admin\SurveyInterface;

class SurveyRepository implements SurveyInterface
{
    private SurveyLanguageRepository $surveyLanguageRepository;

    public function __construct(SurveyLanguageRepository $surveyLanguageRepository)
    {
        $this->surveyLanguageRepository = $surveyLanguageRepository;
    }

    public function paginate($limit)
    {
        return $this->all()->paginate($limit);
    }

    public function get($id)
    {
        return Surveys::find($id);
    }

    public function all()
    {
        return Surveys::all();
    }

    public function find($id)
    {
        return Surveys::find($id);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($request, $id)
    {
        $survey = Surveys::find($id);
        $survey->name = $request->name;
        $survey->question = $request->question;
        $survey->is_active = $request->is_active;

        $survey->save();

        if ($request['translate_id']) {
            $request['lang'] = $request['lang'] ?: 'en';
            $this->surveyLanguageRepository->update($request);
        } else {
            $request['lang'] = $request['lang'] ?: 'en';
            $request['survey_id'] = $survey->id;
            $this->surveyLanguageRepository->store($request);
        }

        return $survey;
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function store($request)
    {
        $survey = new Surveys();

        $survey->name = $request->name;
        $survey->question = $request->question;
        $survey->is_active = $request->is_active;

        $survey->save();

        $request['lang'] = 'en';
        $request['survey_id'] = $survey->id;
        $this->surveyLanguageRepository->store($request);
    }

    public function getByLang($id, $lang)
    {
        if ($lang == null) {
            $slideByLang = SurveyLanguage::where('lang', 'en')->where('survey_id', $id)->first();
        } else {
            $slideByLang = SurveyLanguage::where('lang', $lang)->where('survey_id', $id)->first();
            if (blank($slideByLang)) {
                $slideByLang = SurveyLanguage::where('lang', 'en')->where('survey_id', $id)->first();
                $slideByLang['translation_null'] = 'not-found';
            }
        }

        return $slideByLang;
    }
}