<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-title">
            <h2>Auditoria</h2>
            <p>Puedes buscar modificaciones, registros y eliminaciones en la base de datos.</p>
        </div>
        <div class="body-content">
            <form action="" method="POST">
                <div class="two-rows margin-top">
                    <div class="form-control">
                        <label for="startDate">Desde</label>
                        <input type="date" name="startDate" id="startDate" value="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="form-control">
                        <label for="endDate">Hasta</label>
                        <input type="date" name="endDate" id="endDate" value="<?= date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="form-control margin-top">
                    <label for="searchAudit">Buscar:</label>
                    <input type="text" id="searchAudit" name="searchAudit" placeholder="Movimientos por usuario" required>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </div>
                <div class="table-container">
                    <table id="tableAudit">
                        <thead>
                            <th>Nº</th>
                            <th>Usuario</th>
                            <th>Tabla</th>
                            <th>Solicitud</th>
                            <th>Fecha</th>
                            <th>Detalles</th>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                foreach ($audits as $audit):?>
                                    <tr data-id="<?php echo $audit['id']; ?>">
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $audit['usuario']; ?></td>
                                        <td><?php echo $audit['tabla']; ?></td>
                                        <td><?php echo $audit['operacion']; ?></td>
                                        <td><?php echo $audit['fecha']; ?></td>
                                        <td class="table-options">
                                            <a class="table-edit" href="#">
                                                <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M11 14h1v4h1" /><path d="M12 11h.01" /></svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</section>