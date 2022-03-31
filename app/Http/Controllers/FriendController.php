<?php

namespace App\Http\Controllers;

use App\Services\FriendService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    private FriendService $friendService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->friendService = new FriendService();
    }

    public function index(): Factory|View|Application|RedirectResponse
    {
        try {
            $friends = $this->friendService->getFriends(Auth::user()->getAuthIdentifier());

            return view('friends.index', [
                'friends' => $friends
            ]);
        } catch (\Throwable $throwable) {
            $this->logError($throwable);

            return redirect()
                ->back()
                ->with('error', 'an unknown error has occurred');
        }
    }

    public function add(int $id): RedirectResponse
    {
        try {
            $this->friendService->add(Auth::user()->getAuthIdentifier(), $id);

            return redirect()
                ->back();
        } catch (\Throwable $throwable) {
            $this->logError($throwable);
        }

        return redirect()
            ->back()
            ->with('error', 'An error occurred while adding a friend');
    }

    public function remove(int $id): RedirectResponse
    {
        try {
            $this->friendService->remove(Auth::user()->getAuthIdentifier(), $id);

            return redirect()
                ->back()
                ->with('message', 'Friend successful removed');
        } catch (\Throwable $throwable) {
            $this->logError($throwable);
        }

        return redirect()
            ->back()
            ->with('error', 'An error occurred while removing a friend');
    }
}
