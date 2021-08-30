<?php

namespace App\Libraries;

class Token
{
    private $token;

    public function __construct($token = null)
    {
        if (is_null($token)) {
            $this->token = bin2hex(random_bytes(16));
        } else {
            return $this->token = $token;
        }
    }

    public function getValue()
    {
        return $this->token;
    }

    public function getHash()
    {
        return hash_hmac('sha256', $this->token, env('CHAVE_SECRETA_ATIVACAO_CONTA'));
    }
}
