<?php
require_once __DIR__ . '/../models/Colaborador.php';
require_once __DIR__ . '/../models/PerfilLaboral.php';

class ReporteController
{
    public function listar(): array
    {
        $colaboradores = (new Colaborador())->obtenerTodos();
        $perfil = new PerfilLaboral();

        foreach ($colaboradores as &$colaborador) {
            $perfiles = $perfil->obtenerPorColaborador((int) $colaborador['id']);
            $temas = [];
            $stmt = Conexion::getInstance()->query('SELECT t.nombre FROM colaborador_temas ct JOIN cat_temas t ON t.id = ct.tema_id WHERE ct.colaborador_id = ?', [(int) $colaborador['id']]);
            while ($row = $stmt->fetch()) {
                $temas[] = $row['nombre'];
            }

            $colaborador['temas'] = implode(', ', $temas);
            $colaborador['perfiles'] = $perfiles;
            $colaborador['integridad'] = [];
            foreach ($perfiles as $registro) {
                $colaborador['integridad'][] = [
                    'estado' => $perfil->verificarIntegridad($registro) ? 'validado' : 'corrupto',
                    'firma' => $registro['firma'] ?? '',
                ];
            }
        }

        return $colaboradores;
    }
}
