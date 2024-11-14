<?php

namespace App\Services\SuperAdmin;

use App\Models\Company;
use App\Models\Content;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminService implements SuperAdminServiceInterface
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

        if ($user->role !== "super_admin") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        DB::beginTransaction();

        try {
            $managerData = [
                'name'      => $request->manager_name,
                'email'     => $request->manager_email,
                'phone'     => $request->manager_phone ?? '',
                'address'   => $request->manager_address ?? '',
                'role'      => "manager",
                'password'  => Hash::make("Default123!"),
            ];

            $dataManagerDb = User::create($managerData);

            $data = [
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'user_id' => $dataManagerDb->id
            ];

            $dataDb = Company::create($data);

            DB::commit();

            return response()->json([
                'error'        => false,
                'message'      => 'OK',
                'data'         => [
                    $dataManagerDb,
                    $dataDb
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

        if ($user->role !== "super_admin") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $data = Company::find($id);

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

        if ($user->role !== "super_admin") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $limit = 10;

        $data = Company::orderBy('id', 'asc')->paginate($limit);

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

        if ($user->role !== "super_admin") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $dataDb = Company::find($id);

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

        if ($user->role !== "super_admin") {
            return response()->json([
                'error'        => false,
                'message'      => 'FORBIDDEN ACCESS',
                'data'         => null,
                'status'       => 403
            ], 403);
        }

        $dataDb = Company::find($id);

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
