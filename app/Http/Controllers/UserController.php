<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list()
    {
        // if (Gate::denies('admin-level', true))
        // {
        //     abort(403);
        // }

        Gate::authorize('admin-level');

        $users = $this->userRepository->all();
        return view('user.list', ['users' => $users]);
    }

    public function show(int $userId)
    {
        Gate::authorize('admin-level');
        $userModel = $this->userRepository->get($userId);
        Gate::authorize('view', $userModel);
        return view('user.show', [
            'user' => $userModel
        ]);
    }
}
