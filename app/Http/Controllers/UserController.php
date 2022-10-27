<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            Log::info(Auth::user());
            return Auth::user();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Failed to get user'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
