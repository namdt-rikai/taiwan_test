<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Get list user from github
     *
     * @return json
     */
    public function getListUser()
    {
        $gitUrl = config('github.github_url');
        $response = Http::withHeaders(
            [
                'Accept' => 'application/vnd.github+json',
            ]
        )
            ->get("{$gitUrl}/users");
        return response()->json(
            [
                'data' => $response->object(),
                'total' => count($response->object())
            ]
        );
    }

    public function getUser($userName)
    {
        $gitUrl = config('github.github_url');
        $response = Http::withHeaders(
            [
                'Accept' => 'application/vnd.github+json',
            ]
        )
            ->get("{$gitUrl}/users/{$userName}");
            return response()->json(
                [
                    'data' => $response->object()
                ]
            );
    }
}
