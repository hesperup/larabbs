<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use  Illuminate\Support\Str;

class VerificationCodesController extends Controller
{
    //
    public function store(VerificationCodeRequest $req, EasySms $easySms)
    {
        $captchaData = Cache::get($req->captcha_key);
        if (!$captchaData) {
            return $this->response->error('图片验证码已失效', 403);
        }
        // Log::error($captchaData['code']);
        // Log::error($req->captcha_code);
        if (!hash_equals(Str::lower($captchaData['code']), Str::lower($req->captcha_code))) {
            // 验证错误就清除缓存
            Cache::forget($req->captcha_key);
            return $this->response->errorUnauthorized('验证码错误', 401);
        }

        $phone = $req->phone;
        if (!app()->environment('production')) {
            $code = '1111';
        } else {
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            try {
                $result = $easySms->send(
                    $phone,
                    ['content' => ' 【XXX】 您的验证码是{$code}']
                );
                $result = true;
            } catch (NoGatewayAvailableException $exception) {
                $message = $exception->getException('yunpian')->getMessage();
                abort(500, $message ?: '短信发送异常');
            }
        }
        $key = 'verificationCode_' . Str::random(15);
        $expiredAt = now()->addMinutes(10);
        Cache::put($key, ['phone' => $phone, 'code' => $code]);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
