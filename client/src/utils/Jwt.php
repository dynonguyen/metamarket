<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtUtil
{
    private static $algorithm = JWT_ALG;
    private static $issuer = JWT_ISSUER;
    private static $key = JWT_SECRET_KEY;

    public static function encode(string | array $sub = '', int $expSeconds = 60, $options = [])
    {
        $now = time();

        $payload = array_merge([
            "iss" => self::$issuer,
            "iat" => $now,
            "exp" => $now + $expSeconds,
            "sub" => $sub
        ], $options);

        $jwt = JWT::encode($payload, self::$key, self::$algorithm);
        return $jwt;
    }

    public static function decode(string $jwt, bool $isArray = true)
    {
        try {
            $decoded = JWT::decode($jwt, new Key(self::$key, self::$algorithm));
            return $isArray ? (array) $decoded : $decoded;
        } catch (Exception $ex) {
            error_log($ex);
            return null;
        }
    }
}
