<?php
require_once __DIR__ . '/../config/Conexion.php';

class Colaborador
{
    private Conexion $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getInstance();
    }

    public function crear(array $datos): int
    {
        return $this->conexion->insert('datospersonales', [
            'identidad' => $datos['identidad'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'edad' => $datos['edad'],
            'tipo_sangre_id' => $datos['tipo_sangre_id'],
            'sexo' => $datos['sexo'],
            'nacionalidad_id' => $datos['nacionalidad_id'],
            'ruta_id' => $datos['ruta_id'],
            'correo' => $datos['correo'],
            'celular' => $datos['celular'],
            'observaciones' => $datos['observaciones'] ?? null,
        ]);
    }

    public function guardarTemas(int $colaboradorId, array $temas): void
    {
        $this->conexion->query('DELETE FROM colaborador_temas WHERE colaborador_id = ?', [$colaboradorId]);
        foreach ($temas as $temaId) {
            $this->conexion->insert('colaborador_temas', [
                'colaborador_id' => $colaboradorId,
                'tema_id' => $temaId,
            ]);
        }
    }

    public function obtenerTodos(): array
    {
        return $this->conexion->fetchAll('SELECT c.*, p.nombre AS pais, r.nombre AS ruta FROM datospersonales c LEFT JOIN cat_paises p ON p.id = c.nacionalidad_id LEFT JOIN cat_rutas r ON r.id = c.ruta_id ORDER BY c.id DESC');
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT * FROM datospersonales WHERE id = ?';
        return $this->conexion->fetchOne($sql, [$id]);
    }
}
