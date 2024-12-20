<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-title">
            <h2>Informes</h2>
            <p>Puedes generar documentos sobre cualquier cosa</p>
        </div>
        <div class="body-content">
            <!-- Generar informe general de la pagina -->
            <form id="informs" action="">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Generar informe general</h4>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Generar">
                </div>
            </form>
            <!-- Compara informe del sistema de ventas con lps codigos de la pagina y mira direfencia de stock y precio -->
            <form id="informForDiference" action="" enctype="multipart/form-data">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Comparar productos via excel</h4>
                </div>
                <div class="select-container">
                    <label for="ofert">Con o sin oferta</label>
                    <select id="ofert" name="ofert" class="select-box category" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="0">Solo sin ofertas</option>
                        <option value="1">Solo ofertas</option>
                    </select>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                </div>
                <div class="form-control">
                    <label for="idfileExcel" class="file">Adjuntar archivo excel</label>
                    <input type="file" name="fileExcel" id="idfileExcel" accept=".xls, .xlsx, .csv, .txt" required>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Verificar datos">
                </div>
            </form>
            <!-- Actualizar productos via excel -->
            <form id="updatingData" action="" enctype="multipart/form-data">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Actualizar productos via excel</h4>
                </div>
                <div class="select-container">
                    <label for="updateProducts">Por precios o stock</label>
                    <select id="updateProducts" name="updateProducts" class="select-box category" required>
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="0">Precios</option>
                        <option value="1">Stock</option>
                        <option value="2">Todos</option>
                    </select>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                </div>
                <div class="form-control">
                    <label for="idUpdateData" class="file">Adjuntar archivo excel</label>
                    <input type="file" name="fileExcel" id="idUpdateData" accept=".xls, .xlsx, .csv, .txt" required>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Actualizar datos">
                </div>
            </form>
            <!-- Generar reporte de productos que no están en la web y si en sistema -->
            <form id="reportNewProducts" action="" enctype="multipart/form-data">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Generar reporte de productos que no están en la web y si en sistema</h4>
                </div>
                <div class="form-control">
                    <label for="idReportNewProducts" class="file">Adjuntar archivo excel</label>
                    <input type="file" name="fileExcel" id="idReportNewProducts" accept=".xls, .xlsx, .csv, .txt" required>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Productos faltantes">
                </div>
            </form>
        </div>
    </div>
</section>