<?php
class Catalogo
{
    private Conexion $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::getInstance();
    }

    public function listar(string $tabla): array
    {
        return $this->conexion->fetchAll('SELECT id, nombre FROM ' . $tabla . ' ORDER BY nombre');
    }

    public function listarTiposSangre(): array
    {
        return $this->conexion->fetchAll('SELECT id, Nombre AS nombre FROM cat_tiposangre ORDER BY Nombre');
    }

    public function listarRutas(): array
    {
        return $this->conexion->fetchAll('SELECT id, Nombre AS nombre FROM cat_rutas ORDER BY Nombre');
    }

    public function listarPaises(): array
    {
        return $this->conexion->fetchAll('SELECT id, nombre FROM cat_paises ORDER BY nombre');
    }

    public function listarOcupaciones(): array
    {
        return $this->conexion->fetchAll('SELECT C_OCUP AS id, OCUPACION AS nombre FROM cat_ocupaciones WHERE Activo = 1 ORDER BY OCUPACION');
    }

    public function listarPlanillas(): array
    {
        return $this->conexion->fetchAll('SELECT id, Nombre AS nombre FROM cat_tipoempleado WHERE Activo = 1 ORDER BY Nombre');
    }

    public function listarTemas(): array
    {
        return $this->conexion->fetchAll('SELECT id, nombre FROM cat_temas ORDER BY nombre');
    }
}
