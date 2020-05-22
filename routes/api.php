<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

$api = app('Dingo\Api\Routing\Router');
$api->version(
    'v1',
    [
        'namespace' => 'App\Http\Controllers\Api'
    ],
    function ($api) {
        # code.
        $api->group(
            [
                'middleware' => 'api.throttle',
                'limit' => config('api.rate_limits.sign.limit'),
                'expires' => config('api.rate_limits.sign.expires'),
            ],
            function ($api) {
                //手机发送验证码
                $api->post('verificationCodes', 'VerificationCodesController@store')
                    ->name('api.verficationCodes.stote');
                //用户注册
                $api->post('users', 'UsersController@store')
                    ->name('api.users.store');

                // 图片验证码
                $api->post('captchas', 'CaptchasController@store')
                    ->name('api.captchas.store');
            }
        );
    }
);
