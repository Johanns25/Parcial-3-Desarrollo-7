<?php
require_once __DIR__ . '/../config/Conexion.php';
require_once __DIR__ . '/../models/Catalogo.php';
require_once __DIR__ . '/../controllers/ColaboradorController.php';
require_once __DIR__ . '/../controllers/PerfilLaboralController.php';
require_once __DIR__ . '/../controllers/ReporteController.php';

$catalogo = new Catalogo();
$tiposSangre = $catalogo->listarTiposSangre();
$paises = $catalogo->listarPaises();
$rutas = $catalogo->listarRutas();
$temas = $catalogo->listarTemas();
$ocupaciones = $catalogo->listarOcupaciones();
$planillas = $catalogo->listarPlanillas();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $colaboradorController = new ColaboradorController();
    $colaboradorResult = $colaboradorController->guardar($_POST);
    if ($colaboradorResult['ok']) {
        $perfilController = new PerfilLaboralController();
        $perfilResult = $perfilController->guardar(array_merge($_POST, ['colaborador_id' => $colaboradorResult['id']]));
        if ($perfilResult['ok']) {
            $success = true;
        } else {
            $errors = $perfilResult['errors'];
        }
    } else {
        $errors = $colaboradorResult['errors'];
    }
}

if (($_GET['action'] ?? '') === 'reporte') {
    $registros = (new ReporteController())->listar();
    include __DIR__ . '/../views/reporte/reporte.php';
} else {
    include __DIR__ . '/../views/colaborador/formulario.php';
}
