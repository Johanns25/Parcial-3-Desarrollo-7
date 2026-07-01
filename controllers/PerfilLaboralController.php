<?php
require_once __DIR__ . '/../helpers/Validator.php';
require_once __DIR__ . '/../models/PerfilLaboral.php';

class PerfilLaboralController
{
    public function guardar(array $post): array
    {
        $errors = [];
        $fechaInicio = trim((string) ($post['fecha_inicio'] ?? ''));
        $fechaFin = trim((string) ($post['fecha_fin'] ?? ''));
        $motivoBaja = trim((string) ($post['motivo_baja'] ?? ''));

        $datos = [
            'colaborador_id' => (int) ($post['colaborador_id'] ?? 0),
            'ocupacion_id' => (int) ($post['ocupacion_id'] ?? 0),
            'tipo_planilla_id' => (int) ($post['tipo_planilla_id'] ?? 0),
            'salario' => (float) ($post['salario'] ?? 0),
            'cargo_activo' => isset($post['cargo_activo']) ? (int) $post['cargo_activo'] : 1,
            'empleado_activo' => isset($post['empleado_activo']) ? (int) $post['empleado_activo'] : 1,
            'fecha_inicio' => $fechaInicio !== '' ? $fechaInicio : null,
            'fecha_fin' => $fechaFin !== '' ? $fechaFin : null,
            'motivo_baja' => $motivoBaja !== '' ? $motivoBaja : null,
        ];

        if (!Validator::validarOpcion($datos['colaborador_id'])) {
            $errors[] = 'No se recibió un colaborador válido.';
        }
        if (!Validator::validarOpcion($datos['ocupacion_id'])) {
            $errors[] = 'Debe elegir una ocupación válida.';
        }
        if (!Validator::validarOpcion($datos['tipo_planilla_id'])) {
            $errors[] = 'Debe elegir un tipo de planilla válido.';
        }
        if (!Validator::validarSalario($datos['salario'])) {
            $errors[] = 'El salario debe ser mayor que cero.';
        }
        if (!Validator::requerido($datos['fecha_inicio'])) {
            $errors[] = 'La fecha de inicio es obligatoria.';
        } elseif (!Validator::validarFecha($datos['fecha_inicio'])) {
            $errors[] = 'La fecha de inicio no es válida.';
        }
        if ($datos['fecha_fin'] !== null && !Validator::validarFecha($datos['fecha_fin'])) {
            $errors[] = 'La fecha de fin no es válida.';
        }
        if ($datos['fecha_inicio'] !== null && $datos['fecha_fin'] !== null && !Validator::validarRangoFechas($datos['fecha_inicio'], $datos['fecha_fin'])) {
            $errors[] = 'La fecha de fin no puede ser menor que la fecha de inicio.';
        }
        if (!Validator::validarBaja($datos['fecha_fin'], $datos['motivo_baja'])) {
            $errors[] = 'Si registra una baja, debe indicar el motivo.';
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors, 'datos' => $datos];
        }

        $modelo = new PerfilLaboral();
        if (!empty($datos['fecha_fin'])) {
            $datos['empleado_activo'] = 0;
        }

        $id = $modelo->crear($datos);

        return ['ok' => true, 'id' => $id, 'datos' => $datos];
    }
}
