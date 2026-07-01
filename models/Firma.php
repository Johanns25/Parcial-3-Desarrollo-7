<?php
class Firma
{
    private string $secret;

    public function __construct(string $secret = 'itech-secret-2026')
    {
        $this->secret = $secret;
    }

    public function firmar(array $datos): string
    {
        ksort($datos);
        return hash_hmac('sha256', json_encode($datos, JSON_UNESCAPED_UNICODE), $this->secret);
    }

    public function verificar(array $datos, string $firma): bool
    {
        return hash_equals($this->firmar($datos), $firma);
    }
}
