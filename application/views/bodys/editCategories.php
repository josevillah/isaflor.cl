<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-title">
            <h2>Modifica tu Categoría</h2>
            <p>Escribe el nombre de la categoría</p>
        </div>
        <div class="body-content">
            <form id="formEditCategory" action="">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Crear categoría</h4>
                </div>
                <div class="form-control">
                    <label for="categoryName">Nombre de categoría:</label>
                    <input type="text" class="categoryName" id="categoryName" name="categoryName" placeholder="Nombre de la categoría" required value="<?php echo $data['nombre']; ?>">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6zm10 0h6v6h-6zm-10 10h6v6h-6zm10 3h6m-3 -3v6" /></svg>
                </div>
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                <div class="form-control end-form">
                    <input type="submit" value="Modificar">
                </div>
            </form>
        </div>
    </div>
</section>