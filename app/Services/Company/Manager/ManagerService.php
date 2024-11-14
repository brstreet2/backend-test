<?php

namespace App\Services\Company\Manager;

use App\Enum\Role\RoleEnum;
use App\Models\CompanyEmployees;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerService implements ManagerServiceInterface
{
    public function create($request)
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

        $user = Auth::user();

        if ($user->role !== "manager") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        DB::beginTransaction();

        try {
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'role'      => $request->role,
                'password'  => Hash::make("Default123!"),
            ];

            $dataDb = User::create($data);

            CompanyEmployees::create([
                'user_id'       => $dataDb->id,
                'company_id'    => Auth::user()->company->id
            ]);

            DB::commit();

            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => [
                    $dataDb,
                ],
                'status'       => 201
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'        => true,
                'message'      => $e->getMessage(),
                'data'         => null,
                'status'       => 500
            ], 500);
        }
    }

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

        $user = Auth::user();

        if ($user->role !== "manager") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
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

        if ($user->role !== "manager") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $limit = 2;

        $query = User::with(['company', 'company_employee'])
            ->whereIn('role', ['manager', 'employee']);

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

    public function update($id, $request)
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

        $user = Auth::user();

        if ($user->role !== "manager") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        if (!$id) {
            return response()->json([
                'error'        => true,
                'message'      => 'MISSING ID',
                'data'         => null,
                'status'       => 400
            ], 400);
        }

        $dataDb = User::find($id);

        if (!$dataDb) {
            return response()->json([
                'error'        => false,
                'message'      => 'NO DATA',
                'data'         => null,
                'status'       => 200
            ], 200);
        }

        if ($dataDb->role === RoleEnum::MANAGER) {
            if ($user->id !== $id) {
                return response()->json([
                    'error'        => false,
                    'message'      => 'YOU CAN ONLY UPDATE YOUR OWN DATA',
                    'data'         => null,
                    'status'       => 403
                ], 403);
            }
        }

        DB::beginTransaction();

        try {
            $updatedField = [
                'name'    => $request->name ?: $dataDb->name,
                'email'   => $request->email ?: $dataDb->email,
                'phone'   => $request->phone ?: $dataDb->phone,
                'user_id' => $request->user_id ?: $dataDb->user_id
            ];
            $dataDb->update($updatedField);

            DB::commit();

            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => $dataDb,
                'status'       => 200
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'        => true,
                'message'      => $e->getMessage(),
                'data'         => null,
                'status'       => 500
            ], 500);
        }
    }

    public function delete($id, $request)
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

        $user = Auth::user();

        if ($user->role !== "manager") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $dataDb = User::find($id);

        if (!$dataDb) {
            return response()->json([
                'error'        => false,
                'message'      => 'NO DATA',
                'data'         => null,
                'status'       => 200
            ], 200);
        }

        DB::beginTransaction();

        try {
            $dataDb->deleted_at = Carbon::now();

            DB::commit();

            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => $dataDb,
                'status'       => 200
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'        => true,
                'message'      => $e->getMessage(),
                'data'         => null,
                'status'       => 500
            ], 500);
        }
    }
}
