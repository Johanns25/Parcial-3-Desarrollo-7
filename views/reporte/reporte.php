<?php require_once __DIR__ . '/../partials/header.php'; ?>

<section class="card">
    <h2>Reporte de colaboradores</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Colaborador</th>
                <th>Correo</th>
                <th>Temas</th>
                <th>Perfiles</th>
                <th>Integridad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?php echo (int) $registro['id']; ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($registro['correo']); ?></td>
                    <td><?php echo htmlspecialchars($registro['temas']); ?></td>
                    <td>
                        <?php foreach ($registro['perfiles'] as $perfil): ?>
                            <div class="perfil-item">
                                <?php echo htmlspecialchars($perfil['ocupacion'] . ' / ' . $perfil['planilla'] . ' / ' . $perfil['salario']); ?>
                                <?php if (!empty($perfil['fecha_fin'])): ?>
                                    <span class="badge bad">Baja</span>
                                <?php else: ?>
                                    <span class="badge ok">Activo</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($registro['integridad'] as $item): ?>
                            <span class="badge <?php echo $item['estado'] === 'validado' ? 'ok' : 'bad'; ?>"><?php echo $item['estado']; ?></span>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
