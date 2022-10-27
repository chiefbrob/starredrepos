<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Log;

trait HasGithubToken
{
    public function decryptedGithubToken()
    {
        if ($this->github_token == null) {
            return false;
        }

        $github_token = false;
        
        try {
            $github_token = decrypt($this->github_token);
        } catch (DecryptException $e) {
            Log::error($e);
        }
        return $github_token;
    }

    public function setGithubToken(String $github_token)
    {
        $this->github_token = encrypt($github_token);
        return $this->save();
    }

    public function deleteGithubToken()
    {
        if ($this->github_token == null) {
            return true;
        }
        $this->github_token = null;
        return $this->save();
    }
}
