<?php

namespace App\Services\Company\Employee;

use App\Enum\Role\RoleEnum;
use App\Models\CompanyEmployees;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService implements EmployeeServiceInterface
{
    public function getById($id, $request)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error'        => false,
                'message'      => 'INVALID TOKEN',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        $token = auth('api')->check($request->bearerToken());

        if (!$token) {
            return response()->json([
                'error'        => false,
                'message'      => 'UNAUTHORIZED',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        $data = User::with(['company', 'company_employee'])->find($id);

        if (!$data) {
            return response()->json([
                'error'        => false,
                'message'      => 'NO DATA',
                'data'         => null,
                'status'       => 200
            ], 200);
        }

        return response()->json([
            'error'        => false,
            'message'      => 'OK',
            'data'         => $data,
            'status'       => 200
        ], 200);
    }

    public function getAll($request)
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'error'        => false,
                'message'      => 'INVALID TOKEN',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        $token = auth('api')->check($request->bearerToken);

        if (!$token) {
            return response()->json([
                'error'        => false,
                'message'      => 'UNAUTHORIZED',
                'data'         => null,
                'status'       => 401
            ], 401);
        }

        $user = Auth::user();

        $limit = 2;

        $query = User::with(['company', 'company_employee'])
            ->whereIn('role', [RoleEnum::EMPLOYEE]);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        $allowedSortFields = ['id', 'email', 'name', 'phone', 'address', 'role'];

        if ($request->has('sortBy') && !empty($request->sortBy)) {
            if (in_array($request->sortBy, $allowedSortFields)) {
                $sortOrder = $request->has('sortOrder') && in_array($request->sortOrder, ['asc', 'desc']) ? $request->sortOrder : 'asc';
                $query->orderBy($request->sortBy, $sortOrder);
            } else {
                return response()->json([
                    'error'     => true,
                    'message'   => 'Invalid sort field. Allowed sort fields are: ' . implode(', ', $allowedSortFields),
                    'data'      => null,
                    'status'    => 400
                ], 400);
            }
        }

        $data = $query->paginate($limit);

        return response()->json([
            'error'        => false,
            'message'      => 'OK',
            'data'         => $data,
            'status'       => 200
        ], 200);
    }
}
