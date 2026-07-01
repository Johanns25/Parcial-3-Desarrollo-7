<?php
class Validator
{
    public static function requerido($valor): bool
    {
        return trim((string) $valor) !== '';
    }

    public static function validarDocumento($valor): bool
    {
        $valor = trim((string) $valor);
        return preg_match('/^([A-Za-z]{2}-)?\d{1,2}-\d{3,4}-\d{4}$/', $valor) === 1
            || preg_match('/^[0-9A-Za-z-]{4,20}$/', $valor) === 1;
    }

    public static function validarDocumentoPanama($valor): bool
    {
        return preg_match('/^([A-Za-z]{2}-)?\d{1,2}-\d{3,4}-\d{4}$/', trim((string) $valor)) === 1;
    }

    public static function validarEdad($valor): bool
    {
        return is_numeric($valor) && (int) $valor >= 16 && (int) $valor <= 99;
    }

    public static function validarSexo($valor): bool
    {
        return in_array(trim((string) $valor), ['Masculino', 'Femenino', 'Otro'], true);
    }

    public static function validarOpcion($valor): bool
    {
        return is_numeric($valor) && (int) $valor > 0;
    }

    public static function validarCorreo($valor): bool
    {
        return filter_var(trim((string) $valor), FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validarCelular($valor): bool
    {
        return preg_match('/^\+?[0-9\s-]{7,15}$/', trim((string) $valor)) === 1;
    }

    public static function validarFecha($valor): bool
    {
        if ($valor === null || $valor === '') {
            return true;
        }

        $fecha = DateTimeImmutable::createFromFormat('Y-m-d', trim((string) $valor));
        return $fecha instanceof DateTimeImmutable && $fecha->format('Y-m-d') === trim((string) $valor);
    }

    public static function validarSalario($valor): bool
    {
        return is_numeric($valor) && (float) $valor > 0;
    }

    public static function validarRangoFechas($fechaInicio, $fechaFin): bool
    {
        if ($fechaInicio === null || $fechaInicio === '' || $fechaFin === null || $fechaFin === '') {
            return true;
        }

        return self::validarFecha($fechaInicio) && self::validarFecha($fechaFin) && strtotime($fechaFin) >= strtotime($fechaInicio);
    }

    public static function validarBaja($fechaFin, $motivo): bool
    {
        if ($fechaFin === null || $fechaFin === '') {
            return true;
        }

        return self::requerido($motivo);
    }
}
