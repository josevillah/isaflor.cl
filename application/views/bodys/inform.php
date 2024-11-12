<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-title">
            <h2>Informes</h2>
            <p>Puedes generar documentos sobre cualquier cosa</p>
        </div>
        <div class="body-content">
            <form id="informs" action="">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Generar informe general</h4>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Generar">
                </div>
            </form>
            <form id="formNewCategory" action="">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Comparar productos via excel</h4>
                </div>
                <div class="form-container">
                    <div class="two-rows">
                        <div class="select-container">
                            <label for="selectCategory">Categorías</label>
                            <select id="selectCategory" name="selectCategory" class="select-box category" required>
                                <option value="0" disabled selected>Selecciona una categoría</option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </div>
                        <div class="select-container">
                            <label for="selectSubcategory">Sub categorías</label>
                            <select id="selectSubcategory" name="selectSubcategory" class="select-box subcategories" required></select>
                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>