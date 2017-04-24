<?php

namespace Mhaoxyz\Laravel\VerifyCode;

class KeyCode
{
    protected $key_header = 'mhaoxyz-verifyCode-key-code-';

    public function randCode()
    {
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        return $code;
    }

    public function cacheCode($key, $code)
    {
        $key = $this->key_header . $key;
        cache([
            $key => $code
        ], 10); // 缓存验证码，有效10分钟
    }

    public function randCodeAndCache($key)
    {
        $code = $this->randCode();
        $this->cacheCode($key, $code);
        return $code;
    }

    public function verify($key, $code)
    {
        $key = $this->key_header . $key;
        $cache_code = cache($key);

        return $code == $cache_code;
    }
}