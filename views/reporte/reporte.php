<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section class="card">
    <h2>Reporte de colaboradores</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Colaborador</th>
                <th>Correo</th>
                <th>Perfil Laboral</th>
                <th>Estado</th>
                <th>Integridad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro): ?>
                <?php if (empty($registro['perfiles'])): ?>
                    <tr>
                        <td><?php echo (int) $registro['id']; ?></td>
                        <td><?php echo htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($registro['correo']); ?></td>
                        <td colspan="3" style="text-align: center; color: #999;">Sin perfiles asignados</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($registro['perfiles'] as $indice => $perfil): ?>
                        <tr>
                            <?php if ($indice === 0): ?>
                                <td rowspan="<?php echo count($registro['perfiles']); ?>"><?php echo (int) $registro['id']; ?></td>
                                <td rowspan="<?php echo count($registro['perfiles']); ?>"><?php echo htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']); ?></td>
                                <td rowspan="<?php echo count($registro['perfiles']); ?>"><?php echo htmlspecialchars($registro['correo']); ?></td>
                            <?php endif; ?>
                            <td>
                                <div><?php echo htmlspecialchars($perfil['ocupacion'] . ' / ' . $perfil['planilla']); ?></div>
                                <div style="font-size: 0.9em; color: #666;">Salario: $<?php echo number_format($perfil['salario'], 2); ?></div>
                                <div style="font-size: 0.9em; color: #666;">Desde: <?php echo date('d/m/Y', strtotime($perfil['fecha_inicio'])); ?></div>
                            </td>
                            <td>
                                <?php if (!empty($perfil['fecha_fin'])): ?>
                                    <span class="badge bad">Baja</span>
                                    <div style="font-size: 0.9em; margin-top: 5px;">Hasta: <?php echo date('d/m/Y', strtotime($perfil['fecha_fin'])); ?></div>
                                <?php else: ?>
                                    <span class="badge ok">Activo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($registro['integridad'][$indice])): ?>
                                    <span class="badge <?php echo $registro['integridad'][$indice]['estado'] === 'validado' ? 'ok' : 'bad'; ?>">
                                        <?php echo ucfirst($registro['integridad'][$indice]['estado']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
