<?php

namespace App\Repositories\Interfaces\Admin;

interface EmailTemplateLanguageInterface {

    public function find($id);

    public function store($request);

    public function update($request);
}
