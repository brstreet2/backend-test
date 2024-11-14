<?php

namespace App\Http\Controllers\Api\Company\Manager;

use App\Http\Controllers\Controller;
use App\Requests\Company\Manager\CreateEmployeeRequest;
use App\Services\Company\Manager\ManagerServiceInterface;
use Illuminate\Http\Request;

class ApiManagerController extends Controller
{
    public function create(CreateEmployeeRequest $request, ManagerServiceInterface $managerServiceInterface)
    {
        return $managerServiceInterface->create($request);
    }

    public function getById($id, ManagerServiceInterface $managerServiceInterface)
    {
        return $managerServiceInterface->getById($id, request());
    }

    public function getAll(ManagerServiceInterface $managerServiceInterface)
    {
        return $managerServiceInterface->getAll(request());
    }

    public function update($id, Request $request, ManagerServiceInterface $managerServiceInterface)
    {
        return $managerServiceInterface->update($id, $request);
    }

    public function delete($id, Request $request, ManagerServiceInterface $managerServiceInterface)
    {
        return $managerServiceInterface->delete($id, $request);
    }
}
