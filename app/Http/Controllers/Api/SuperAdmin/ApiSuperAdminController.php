<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Requests\SuperAdmin\CreateCompanyRequest;
use App\Services\SuperAdmin\SuperAdminServiceInterface;
use Illuminate\Http\Request;

class ApiSuperAdminController extends Controller
{
    public function create(CreateCompanyRequest $request, SuperAdminServiceInterface $superAdminServiceInterface)
    {
        return $superAdminServiceInterface->create($request);
    }

    public function getById($id, SuperAdminServiceInterface $superAdminServiceInterface)
    {
        return $superAdminServiceInterface->getById($id, request());
    }

    public function getAll(SuperAdminServiceInterface $superAdminServiceInterface)
    {
        return $superAdminServiceInterface->getAll(request());
    }

    public function update($id, Request $request, SuperAdminServiceInterface $superAdminServiceInterface)
    {
        return $superAdminServiceInterface->update($id, $request);
    }

    public function delete($id, Request $request, SuperAdminServiceInterface $superAdminServiceInterface)
    {
        return $superAdminServiceInterface->delete($id, $request);
    }
}
