<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailTemplateRequest;
use App\Http\Requests\Admin\ServiceRequest;
use App\Repositories\Interfaces\Admin\EmailTemplateInterface;
use App\Repositories\Interfaces\Admin\LanguageInterface;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{

    private EmailTemplateInterface $emailTemplate;

    public function __construct(
        EmailTemplateInterface $emailTemplate
    )  {
        $this->emailTemplate = $emailTemplate;
    }
    public function index()
    {
        try {
            $data = [
                'emailTemplates' => $this->emailTemplate->all()
            ];
            return view('admin.email_template.index', $data);
        } catch (\Exception $exception) {
            Toastr::error($exception->getMessage());
            return back();
        }
    }

    public function create()
    {
        return view('admin.email_template.form');
    }

    public function store(EmailTemplateRequest $request)
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;
        try {
            $this->emailTemplate->store($request);

            Toastr::success(__('Created Successfully'));
            return redirect()->route('templates.index');
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }

    }

    public function edit($id, Request $request, LanguageInterface $language)
    {
        try {
            $data = [
                'edit' => $this->emailTemplate->find($id),
                'r'    => $request->r != ''? $request->r : $request->server('HTTP_REFERER'),
                'languages' => $language->all()->orderBy('id', 'asc')->get(),
                'lang' => $request->lang ? : app()->getLocale(),
            ];

            $data['email_template_language'] = $this->emailTemplate->getByLang($id, $data['lang']);
            return view('admin.email_template.form', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }

    public function update(EmailTemplateRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        if (config('app.demo_mode')):
            Toastr::info(__('This function is disabled in demo server.'));
            return redirect()->back();
        endif;
        try {
            $this->emailTemplate->update($request, $id);
            Toastr::success(__('Updated Successfully'));
            return redirect()->route('templates.index');

        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }
    }
}