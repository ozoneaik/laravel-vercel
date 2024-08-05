<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class testController extends Controller
{
    public function users(): JsonResponse
    {
        $perPage = 10;
        $users = User::paginate($perPage);
        return response()->json($users,200);
    }

    public function testPost(Request $request) : JsonResponse{
        $R = $request->all();
        return response()->json([
           'response' => $R
        ]);
    }
}
