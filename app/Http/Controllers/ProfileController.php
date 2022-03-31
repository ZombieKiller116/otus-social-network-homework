<?php

namespace App\Http\Controllers;

use App\Services\FriendService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private UserService $userService;
    private FriendService $friendService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->userService = new UserService();
        $this->friendService = new FriendService();
    }

    public function show(int $userId = 0): Factory|View|Application
    {
        if(!$userId) {
            $userId = Auth::id();
        } else {
            $friendStatus = $this->friendService->getStatus(Auth::id(), $userId);
        }

        $userData = $this->userService->getUserData($userId);

        return view('profiles.show', [
            'userData' => $userData,
            'friendStatus' => $friendStatus ?? null
        ]);
    }

    public function list(): Factory|View|Application
    {
        $users = $this->userService->getAllUsers();

        return view('profiles.list', [
            'users' => $users
        ]);
    }
}
