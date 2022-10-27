<?php

namespace App\Http\Controllers\Github;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use GrahamCampbell\GitHub\GitHubFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GetStarredRepositoriesController extends Controller
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
            $github_token = $user->decryptedGithubToken();
            $client = app(GitHubFactory::class)->make(
                [
                'method'     => 'token',
                'token'      => $github_token,
                'cache'     => true,
                'backoff'   => true
                ]
            );
            return $client->api('current_user')->starring()->all();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to get starred repositories'], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
