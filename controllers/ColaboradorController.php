<?php
require_once __DIR__ . '/../helpers/Validator.php';
require_once __DIR__ . '/../helpers/Sanitizer.php';
require_once __DIR__ . '/../models/Colaborador.php';

class ColaboradorController
{
    public function guardar(array $post): array
    {
        $errors = [];

        $datos = [
            'identidad' => Sanitizer::limpiarTexto($post['identidad'] ?? ''),
            'nombre' => Sanitizer::toTitleCase($post['nombre'] ?? ''),
            'apellido' => Sanitizer::toTitleCase($post['apellido'] ?? ''),
            'edad' => Sanitizer::limpiarEntero($post['edad'] ?? 0),
            'tipo_sangre_id' => Sanitizer::limpiarEntero($post['tipo_sangre_id'] ?? 0),
            'sexo' => Sanitizer::limpiarTexto($post['sexo'] ?? ''),
            'nacionalidad_id' => Sanitizer::limpiarEntero($post['nacionalidad_id'] ?? 0),
            'ruta_id' => Sanitizer::limpiarEntero($post['ruta_id'] ?? 0),
            'correo' => Sanitizer::limpiarCorreo($post['correo'] ?? ''),
            'celular' => Sanitizer::limpiarCelular($post['celular'] ?? ''),
            'observaciones' => Sanitizer::limpiarTexto($post['observaciones'] ?? ''),
        ];

        if (!Validator::requerido($datos['identidad']) || !Validator::validarDocumento($datos['identidad'])) {
            $errors[] = 'La identidad es obligatoria y debe tener formato válido.';
        }
        if (!Validator::requerido($datos['nombre'])) {
            $errors[] = 'El nombre es obligatorio.';
        }
        if (!Validator::requerido($datos['apellido'])) {
            $errors[] = 'El apellido es obligatorio.';
        }
        if (!Validator::validarEdad($datos['edad'])) {
            $errors[] = 'La edad debe estar entre 16 y 99 años.';
        }
        if (!Validator::validarSexo($datos['sexo'])) {
            $errors[] = 'El sexo debe ser Masculino, Femenino u Otro.';
        }
        if (!Validator::validarOpcion($datos['tipo_sangre_id'])) {
            $errors[] = 'Debe elegir un tipo de sangre válido.';
        }
        if (!Validator::validarOpcion($datos['nacionalidad_id'])) {
            $errors[] = 'Debe elegir una nacionalidad válida.';
        }
        if (!Validator::validarOpcion($datos['ruta_id'])) {
            $errors[] = 'Debe elegir una ruta válida.';
        }
        if (!Validator::validarCorreo($datos['correo'])) {
            $errors[] = 'El correo no es válido.';
        }
        if (!Validator::validarCelular($datos['celular'])) {
            $errors[] = 'El celular no es válido.';
        }

        if ($errors) {
            return ['ok' => false, 'errors' => $errors, 'datos' => $datos];
        }

        $modelo = new Colaborador();
        $id = $modelo->crear($datos);
        $temas = array_map('intval', $post['temas'] ?? []);
        $modelo->guardarTemas($id, $temas);

        return ['ok' => true, 'id' => $id, 'datos' => $datos];
    }
}
