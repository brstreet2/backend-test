<?php

namespace App\Services\SuperAdmin;

interface SuperAdminServiceInterface
{
    public function getById($id, $request);

    public function getAll($request);

    public function create($request);

    public function update($id, $request);

    public function delete($id, $request);
}
