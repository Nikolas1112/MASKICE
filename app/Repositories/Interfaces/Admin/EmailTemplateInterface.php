<?php

namespace App\Repositories\Interfaces\Admin;

interface EmailTemplateInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function store($request);

}