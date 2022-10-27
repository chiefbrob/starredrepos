<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Http\Requests\Github\SaveTokenRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SaveTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Github\SaveTokenRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SaveTokenRequest $request)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $user->setGithubToken($request->github_token);

            return response([ 'message' => 'ok' ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to save token',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
