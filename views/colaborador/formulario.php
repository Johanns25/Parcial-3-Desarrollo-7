<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section class="card modern-form">

    <div class="hero-panel">
        <div>
            <span class="section-kicker">Gestión Integral</span>
            <h2>👨‍💼 Registro de Colaborador</h2>
            <p>
                Captura los datos personales y la información laboral
                en una sola vista organizada y profesional.
            </p>
        </div>

        <span class="section-pill">
            Nuevo colaborador
        </span>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <strong>⚠ Se encontraron errores:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert success">
            ✅ Registro guardado correctamente.
        </div>
    <?php endif; ?>

    <form method="post" action="index.php">

        <div class="form-shell">

            <!-- DATOS PERSONALES -->

            <section class="form-section">

                <div class="section-header">
                    <div>
                        <span class="section-kicker">
                            Datos Personales
                        </span>

                        <h3>
                            👤 Registro de colaborador
                        </h3>
                    </div>

                    <span class="section-pill subtle">
                        Paso 1
                    </span>
                </div>

                <div class="grid">

                    <label class="field">
                        <span>Identidad</span>
                        <input
                            type="text"
                            name="identidad"
                            required
                            placeholder="Ej. 8-888-8888">
                    </label>

                    <label class="field">
                        <span>Nombre</span>
                        <input
                            type="text"
                            name="nombre"
                            required
                            autocomplete="given-name"
                            placeholder="Ej. Juan">
                    </label>

                    <label class="field">
                        <span>Apellido</span>
                        <input
                            type="text"
                            name="apellido"
                            required
                            autocomplete="family-name"
                            placeholder="Ej. Pérez">
                    </label>

                    <label class="field">
                        <span>Edad</span>
                        <input
                            type="number"
                            name="edad"
                            min="16"
                            max="99"
                            required>
                    </label>

                    <label class="field">
                        <span>Tipo de sangre</span>

                        <select name="tipo_sangre_id" required>
                            <?php foreach ($tiposSangre as $item): ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Sexo</span>

                        <select name="sexo" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </label>

                    <label class="field">
                        <span>Nacionalidad</span>

                        <select name="nacionalidad_id" required>
                            <?php foreach ($paises as $item): ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Ruta</span>

                        <select name="ruta_id" required>
                            <?php foreach ($rutas as $item): ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Correo electrónico</span>

                        <input
                            type="email"
                            name="correo"
                            required
                            autocomplete="email"
                            placeholder="usuario@dominio.com">
                    </label>

                    <label class="field">
                        <span>Celular</span>

                        <input
                            type="text"
                            name="celular"
                            required
                            autocomplete="tel"
                            placeholder="Ej. 6677-8899">
                    </label>


                </div>

            </section>

            <!-- PERFIL LABORAL -->

            <section class="form-section">

                <div class="section-header">
                    <div>
                        <span class="section-kicker">
                            Perfil Laboral
                        </span>

                        <h3>
                            💼 Información profesional
                        </h3>
                    </div>

                    <span class="section-pill subtle">
                        Paso 2
                    </span>
                </div>

                <div class="grid">

                    <label class="field">
                        <span>Ocupación</span>

                        <select name="ocupacion_id" required>
                            <?php foreach ($ocupaciones as $item): ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Tipo de empleado</span>

                        <select name="tipo_planilla_id" required>
                            <option value="">
                                Seleccione un tipo de empleado
                            </option>

                            <?php foreach ($planillas as $item): ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="field">
                        <span>Salario</span>

                        <input
                            type="number"
                            step="0.01"
                            name="salario"
                            required
                            min="1"
                            placeholder="0.00">
                    </label>

                    <label class="field">
                        <span>Fecha de inicio</span>

                        <input
                            type="date"
                            name="fecha_inicio"
                            required>
                    </label>

                    <label class="field">
                        <span>Fecha de fin</span>

                        <input
                            type="date"
                            name="fecha_fin">
                    </label>

                    <label class="field">
                        <span>Motivo de baja</span>

                        <input
                            type="text"
                            name="motivo_baja"
                            placeholder="Requerido si existe fecha de finalización">
                    </label>

                    <div class="field field-wide">

                        <span>
                            Estado laboral y disponibilidad
                        </span>

                        <div class="status-grid">

                            <label class="switch-card">

                                <span class="switch-info">
                                    <strong>Cargo activo</strong>

                                    <small>
                                        Visible dentro de la estructura organizacional.
                                    </small>
                                </span>

                                <span class="switch">
                                    <input
                                        type="checkbox"
                                        name="cargo_activo"
                                        value="1"
                                        checked>

                                    <span class="slider"></span>
                                </span>

                            </label>

                            <label class="switch-card">

                                <span class="switch-info">
                                    <strong>Empleado activo</strong>

                                    <small>
                                        Incluido en operaciones y procesos vigentes.
                                    </small>
                                </span>

                                <span class="switch">
                                    <input
                                        type="checkbox"
                                        name="empleado_activo"
                                        value="1"
                                        checked>

                                    <span class="slider"></span>
                                </span>

                            </label>

                        </div>

                    </div>

                </div>

            </section>

        </div>

        <div class="form-actions">
            <button type="submit">
                💾 Guardar registro
            </button>
        </div>

    </form>

</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>