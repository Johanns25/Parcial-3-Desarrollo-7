<?php
require_once __DIR__ . '/../controllers/ReporteController.php';

$registros = (new ReporteController())->listar();

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=reporte_colaboradores_' . date('Y-m-d') . '.xls');

// Encabezados
echo "ID\tColaborador\tCorreo\tOcupacion\tPlanilla\tSalario\tFecha Inicio\tFecha Fin\tMotivo Baja\tEstado Cargo\tIntegridad\n";

// Datos
foreach ($registros as $registro) {
    if (empty($registro['perfiles'])) {
        // Colaborador sin perfiles
        echo (int) $registro['id'] . "\t" . 
             $registro['nombre'] . ' ' . $registro['apellido'] . "\t" . 
             $registro['correo'] . "\t" . 
             "(Sin perfil)\t(Sin perfil)\t(Sin perfil)\t(Sin perfil)\t(Sin perfil)\t(Sin perfil)\t(Sin perfil)\n";
    } else {
        // Un colaborador puede tener múltiples perfiles
        foreach ($registro['perfiles'] as $indice => $perfil) {
            $integridad = isset($registro['integridad'][$indice]) ? ucfirst($registro['integridad'][$indice]['estado']) : 'Sin validar';
            $estado = !empty($perfil['fecha_fin']) ? 'Baja' : 'Activo';
            
            echo (int) $registro['id'] . "\t" . 
                 $registro['nombre'] . ' ' . $registro['apellido'] . "\t" . 
                 $registro['correo'] . "\t" . 
                 ($perfil['ocupacion'] ?? 'N/A') . "\t" . 
                 ($perfil['planilla'] ?? 'N/A') . "\t" . 
                 number_format($perfil['salario'], 2, '.', '') . "\t" . 
                 ($perfil['fecha_inicio'] ?? 'N/A') . "\t" . 
                 ($perfil['fecha_fin'] ?? 'Vigente') . "\t" . 
                 ($perfil['motivo_baja'] ?? 'N/A') . "\t" . 
                 $estado . "\t" . 
                 $integridad . "\n";
        }
    }
}
