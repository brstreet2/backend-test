<?php

namespace App\Services\Company\Employee;

interface EmployeeServiceInterface
{
    public function getById($id, $request);

    public function getAll($request);
}
