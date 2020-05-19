<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['show']]);
    }
    //
    public function show(User $user)
    {
        # code...
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        # code...
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, UserRequest $request, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        # code...
        $user->update($request->all());
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id,416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
