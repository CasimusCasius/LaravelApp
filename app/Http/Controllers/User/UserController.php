<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserProfile;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function profile()
    {
        return view('me.profile', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('me.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(UpdateUserProfile $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        if (!empty($data['avatar']))
        {
            $path = $data['avatar']->store('avatars', 'public');

            if ($path)
            {
                Storage::disk('public')->delete($user->avatar);
                $data['avatar'] = $path;
            }
        }

        $this->repository->updateModel(Auth::user(), $data);

        return redirect()->route('me.profile')->with('success', 'Profil zaktualizowany');
    }
}
