<?php
require_once __DIR__ . '/../controllers/ReporteController.php';

$registros = (new ReporteController())->listar();

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte_colaboradores.xls');

echo "ID\tColaborador\tCorreo\tTemas\n";
foreach ($registros as $registro) {
    echo (int) $registro['id'] . "\t" . $registro['nombre'] . ' ' . $registro['apellido'] . "\t" . $registro['correo'] . "\t" . $registro['temas'] . "\n";
}
