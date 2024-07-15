<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserFilterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(GetUserFilterRequest $request): JsonResponse
    {
        $users = app(UserService::class)->getWithFilters($request);

        return response()->json($users, 200);
    }

    public function show(Request $request): JsonResponse
    {
        $user = app(UserService::class)->getById($request);

        return response()->json($user, 200);
    }

    public function deletedList(GetUserFilterRequest $request): JsonResponse
    {
        $user = app(UserService::class)->deletedList($request);

        return response()->json($user, 200);
    }

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        $user = app(UserService::class)->update($id, $request);

        return response()->json($user, 200);
    }

    public function delete(Request $request): JsonResponse
    {
        $user = app(UserService::class)->delete($request->ids);

        return response()->json($user, 200);
    }

    public function destroy(Request $request): JsonResponse
    {
        $user = app(UserService::class)->destroy($request->ids);

        return response()->json($user, 200);
    }

    public function restore(Request $request): JsonResponse
    {
        $user = app(UserService::class)->restore($request->ids);

        return response()->json($user, 200);
    }
}
