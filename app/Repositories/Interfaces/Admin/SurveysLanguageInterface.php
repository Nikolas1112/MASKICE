<?php

namespace App\Repositories\Interfaces\Admin;

interface SurveysLanguageInterface
{
    public function find($id);

    public function store($request);

    public function update($request);
}