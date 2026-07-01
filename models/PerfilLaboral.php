<?php
require_once __DIR__ . '/../config/Conexion.php';
require_once __DIR__ . '/Firma.php';

class PerfilLaboral
{
    private Conexion $conexion;
    private Firma $firma;

    public function __construct()
    {
        $this->conexion = Conexion::getInstance();
        $this->firma = new Firma();
    }

    public function crear(array $datos): int
    {
        $payload = [
            'colaborador_id' => $datos['colaborador_id'],
            'tipo_planilla_id' => $datos['tipo_planilla_id'],
            'ocupacion_id' => $datos['ocupacion_id'],
            'salario' => $datos['salario'],
            'fecha_inicio' => $datos['fecha_inicio'],
        ];

        $firma = $this->firma->firmar($payload);

        return $this->conexion->insert('perfiles_laborales', [
            'colaborador_id' => $datos['colaborador_id'],
            'ocupacion_id' => $datos['ocupacion_id'],
            'tipo_planilla_id' => $datos['tipo_planilla_id'],
            'salario' => $datos['salario'],
            'cargo_activo' => $datos['cargo_activo'] ?? 1,
            'empleado_activo' => $datos['empleado_activo'] ?? 1,
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => ($datos['fecha_fin'] ?? '') === '' ? null : $datos['fecha_fin'],
            'motivo_baja' => ($datos['motivo_baja'] ?? '') === '' ? null : $datos['motivo_baja'],
            'firma' => $firma,
        ]);
    }

    public function promover(int $colaboradorId, array $datos): int
    {
        $this->conexion->query('UPDATE perfiles_laborales SET cargo_activo = 0 WHERE colaborador_id = ? AND cargo_activo = 1', [$colaboradorId]);
        return $this->crear(array_merge($datos, ['colaborador_id' => $colaboradorId]));
    }

    public function obtenerPorColaborador(int $colaboradorId): array
    {
        return $this->conexion->fetchAll(
            'SELECT pl.*, o.OCUPACION AS ocupacion, tp.Nombre AS planilla FROM perfiles_laborales pl LEFT JOIN cat_ocupaciones o ON o.C_OCUP = pl.ocupacion_id LEFT JOIN cat_tipoempleado tp ON tp.id = pl.tipo_planilla_id WHERE pl.colaborador_id = ? ORDER BY pl.fecha_inicio DESC',
            [$colaboradorId]
        );
    }

    public function verificarIntegridad(array $registro): bool
    {
        return $this->firma->verificar([
            'colaborador_id' => $registro['colaborador_id'],
            'tipo_planilla_id' => $registro['tipo_planilla_id'],
            'ocupacion_id' => $registro['ocupacion_id'],
            'salario' => $registro['salario'],
            'fecha_inicio' => $registro['fecha_inicio'],
        ], $registro['firma'] ?? '');
    }
}
