<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeleteTokenController extends Controller
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
            $user = User::where('id', Auth::user()->id)->first();
            $user->deleteGithubToken();

            return response([ 'message' => 'ok' ], Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'Failed to delete token',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
