<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-title">
            <h2>Subcategorías</h2>
            <p>Puedes crear y modificar subcategorías</p>
        </div>
        <div class="body-content">
            <form action="" method="POST">
                <div class="form-control">
                    <label for="searchSubCategory">Subcategorías:</label>
                    <input type="text" id="searchSubCategory" name="searchSubCategory" placeholder="Buscar subcategorías" required>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </div>
                <div class="table-container">
                    <table id="subcategories">
                        <thead>
                            <th>Nº</th>
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                            <?php 
                            $contador = 1;
                            foreach($subcategorias as $subcategoria): ?>
                                <tr data-id="<?php echo $subcategoria['id']; ?>">
                                    <td><?php echo $contador ?></td>
                                    <td><?php echo $subcategoria['nombre']; ?></td>
                                    <td class="table-options">
                                        <a class="table-edit" href="#">
                                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                        </a>
                                        <a class="table-trash" href="#">
                                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        </a>
                                    </td>
                                </tr>
                                <?php $contador++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <form id="formNewSubcategory" action="">
                <hr class="divider">
                <div class="info-divider margin-top margin-bot">
                    <h4>Crear subcategorías</h4>
                </div>
                <div class="select-container">
                    <label for="selectCategory">Subcategorías</label>
                    <select id="selectCategory" name="selectCategory" class="select-box category" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <?php foreach($categorias as $categoria): ?>
                            <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                </div>
                <div class="form-control">
                    <label for="categoryName">Nombre de subcategorías:</label>
                    <input type="text" class="categoryName" id="categoryName" name="categoryName" placeholder="Nombre de la nueva subcategorías" required>
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-category-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6zm10 0h6v6h-6zm-10 10h6v6h-6zm10 3h6m-3 -3v6" /></svg>
                </div>
                <div class="form-control end-form">
                    <input type="submit" value="Nueva subcategoría">
                </div>
            </form>
        </div>
    </div>
</section>