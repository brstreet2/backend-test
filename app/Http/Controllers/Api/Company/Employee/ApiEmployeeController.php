<?php

namespace App\Http\Controllers\Api\Company\Employee;

use App\Http\Controllers\Controller;
use App\Services\Company\Employee\EmployeeServiceInterface;
use Illuminate\Http\Request;

class ApiEmployeeController extends Controller
{
    public function getById($id, EmployeeServiceInterface $employeeServiceInterface)
    {
        return $employeeServiceInterface->getById($id, request());
    }

    public function getAll(EmployeeServiceInterface $employeeServiceInterface)
    {
        return $employeeServiceInterface->getAll(request());
    }
}
