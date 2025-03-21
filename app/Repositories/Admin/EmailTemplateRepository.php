<?php

namespace App\Repositories\Admin;

use App\Models\EmailTemplate;
use App\Models\EmailTemplateLanguage;
use App\Models\Service;
use App\Models\ServiceLanguage;
use App\Repositories\Admin\Service\ServiceLangRepository;
use App\Repositories\Interfaces\Admin\EmailTemplateInterface;

class EmailTemplateRepository implements EmailTemplateInterface
{
    private EmailTemplateLanguageRepository $emailTemplateLanguageRepository;

    public function __construct(
        EmailTemplateLanguageRepository $emailTemplateLanguageRepository
    )
    {
        $this->emailTemplateLanguageRepository = $emailTemplateLanguageRepository;
    }

    public function paginate($limit)
    {
        return $this->all()->paginate($limit);
    }

    public function get($id)
    {
        return EmailTemplate::find($id);
    }

    public function all()
    {
        return EmailTemplate::all();
    }

    public function find($id)
    {
        return EmailTemplate::find($id);
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($request, $id)
    {
        $emailTemplate = EmailTemplate::find($id);
        $emailTemplate->name = $request->name;
        $emailTemplate->type = $request->type;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->description = $request->description;
        $emailTemplate->save();

        if ($request['translate_id']) {
            $request['lang'] = $request['lang'] ?: 'en';
            $this->emailTemplateLanguageRepository->update($request);
        } else {
            $request['lang'] = $request['lang'] ?: 'en';
            $request['email_template_id'] = $emailTemplate->id;
            $this->emailTemplateLanguageRepository->store($request);
        }

        return $emailTemplate;
    }

    public function delete($id)
    {
        return EmailTemplate::delete($id);
    }


    public function store($request)
    {
        $emailTemplate = new EmailTemplate();

        $emailTemplate->name = $request->name;
        $emailTemplate->type = $request->type;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->description = $request->description;

        $emailTemplate->save();

        $request['lang'] = 'en';
        $request['email_template_id'] = $emailTemplate->id;
        $this->emailTemplateLanguageRepository->store($request);
    }

    public function getByLang($id, $lang)
    {
        if ($lang == null) {
            $slideByLang = EmailTemplateLanguage::where('lang', 'en')->where('email_template_id', $id)->first();
        } else {
            $slideByLang = EmailTemplateLanguage::where('lang', $lang)->where('email_template_id', $id)->first();
            if (blank($slideByLang)) {
                $slideByLang = EmailTemplateLanguage::where('lang', 'en')->where('email_template_id', $id)->first();
                $slideByLang['translation_null'] = 'not-found';
            }
        }

        return $slideByLang;
    }
}