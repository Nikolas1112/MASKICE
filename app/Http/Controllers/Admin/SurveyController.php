<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTemplateRequest;
use App\Http\Requests\Admin\SurveyRequest;
use App\Repositories\Interfaces\Admin\LanguageInterface;
use App\Repositories\Interfaces\Admin\SurveyInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private SurveyInterface $survey;

    public function __construct(
        SurveyInterface $survey
    ) {
        $this->survey = $survey;
    }

    public function index()
    {
        try {
            $data = [
                'surveys' => $this->survey->all()
            ];

            return view('admin.survey.index', $data);
        } catch (\Exception $exception) {
            Toastr::error($exception->getMessage());
            return back();
        }
    }

    public function create()
    {
        return view('admin.survey.form');
    }

    public function store(SurveyRequest $request)
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;
        try {
            $this->survey->store($request);

            Toastr::success(__('Created Successfully'));
            return redirect()->route('survey.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }

    }

    public function edit($id, Request $request, LanguageInterface $language)
    {
        try {
            $data = [
                'edit' => $this->survey->find($id),
                'r'    => $request->r != ''? $request->r : $request->server('HTTP_REFERER'),
                'languages' => $language->all()->orderBy('id', 'asc')->get(),
                'lang' => $request->lang ? : app()->getLocale(),
            ];

            $data['survey_language'] = $this->survey->getByLang($id, $data['lang']);

            return view('admin.survey.form', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function update(SurveyRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;

        try {
            $this->survey->update($request, $id);
            Toastr::success(__('Updated Successfully'));
            return redirect()->route('survey.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

}