<?php
class Sanitizer
{
    public static function limpiarTexto($valor): string
    {
        return trim(strip_tags((string) $valor));
    }

    public static function limpiarCorreo($valor): string
    {
        $correo = filter_var(self::limpiarTexto($valor), FILTER_SANITIZE_EMAIL);
        return strtolower(trim((string) $correo));
    }

    public static function limpiarCelular($valor): string
    {
        return trim((string) preg_replace('/[^0-9+]/', '', (string) $valor));
    }

    public static function escapar($valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }

    public static function toTitleCase($valor): string
    {
        $texto = self::limpiarTexto($valor);
        if ($texto === '') {
            return '';
        }

        $particulas = ['de', 'del', 'la', 'las', 'el', 'los', 'y', 'al', 'en', 'a', 'o', 'da', 'do'];
        $palabras = preg_split('/\s+/', $texto) ?: [];

        foreach ($palabras as $index => $palabra) {
            $minuscula = mb_strtolower($palabra, 'UTF-8');
            if ($index === 0 || !in_array($minuscula, $particulas, true)) {
                $palabras[$index] = mb_convert_case($palabra, MB_CASE_TITLE, 'UTF-8');
            } else {
                $palabras[$index] = $minuscula;
            }
        }

        return implode(' ', $palabras);
    }

    public static function limpiarEntero($valor): int
    {
        return (int) filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function limpiarDecimal($valor): float
    {
        return (float) filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
