<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\UserRequest;
use App\Models\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    //

    public function store(UserRequest $req)
    {
        $verifyData = Cache::get($req->verification_key);
        if (!$verifyData) {
            abort(403, '验证码已失效');
        }
        if (!hash_equals($verifyData['code'], $req->verification_code)) {
            abort(401, '验证码错误');
        }

        $user = User::create([
            'name' => $req->name,
            'phone' => $verifyData['phone'],
            'password' => $req->password,
        ]);

        // 清除验证码缓存
        Cache::forget($req->verification_key);

        return $this->response->created();
        // return (new User($user))->showSensitiveFields();
        # code...
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
