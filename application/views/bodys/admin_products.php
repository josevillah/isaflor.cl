<section class="dashboard-container">
    <div class="dashboard-body">
        <div class="body-content">
            <form if="formProduct" action="" enctype="multipart/form-data">
                <div id="searchBar" class="two-rows">
                    <div class="form-control">
                        <label for="searchProduct">Buscar</label>
                        <input type="text" id="searchProduct" name="searchProduct" placeholder="Nombre o código del producto">
                        <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                    </div>
                    <div class="btn-container">
                        <button class="btn-new-product">
                            Nuevo
                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tag"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" /></svg>
                        </button>
                    </div>
                </div>
                <hr class="divider">
                <div class="table-container">
                    <table id="productsTable">
                        <thead>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Opciones</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                                <td>--</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="container-btnBack hidden">
                    <button class="back">
                        <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-corner-up-left-double"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 18v-6a3 3 0 0 0 -3 -3h-7" /><path d="M13 13l-4 -4l4 -4m-5 8l-4 -4l4 -4" /></svg>
                        Volver
                    </button>
                    <div class="container-check">
                        <div class="btn-check">
                            <input type="checkbox" name="btn-switch" id="btn-switch">
                            <label for="btn-switch" class="label-switch"></label>
                        </div>
                        <h4>Stock</h4>
                    </div>
                    <button class="btn-delete">
                        <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button>
                </div>
                <div class="form-container hidden">
                    <input type="hidden" name="idProduct" id="idProduct">
                    <div class="two-rows">
                        <div class="select-container">
                            <label for="selectCategory">Categorías</label>
                            <select id="selectCategory" name="selectCategory" class="select-box category" required></select>
                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </div>
                        <div class="select-container">
                            <label for="selectSubcategory">Sub categorías</label>
                            <select id="selectSubcategory" name="selectSubcategory" class="select-box subcategories" required></select>
                            <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </div>
                    </div>
                    <div class="two-rows">
                        <div class="w-50">
                            <div class="form-control">
                                <img class="file" for="productImg" src="" alt="">
                                <label class="file" for="productImg">Elige una imagen</label>
                                <input type="file" name="productImg" id="productImg" accept="*.png,.jpg">
                            </div>
                        </div>
                        <div class="w-50">
                            <div class="form-control">
                                <label for="productCode">código</label>
                                <input type="text" id="productCode" name="productCode" placeholder="Código de producto..." required>
                            </div>
                            <div class="form-control">
                                <label for="productName">Nombre</label>
                                <input type="text" id="productName" name="productName" placeholder="Nombre del producto..." required>
                            </div>
                            <div class="form-control">
                                <label for="productPrice">Precio</label>
                                <input type="number" id="productPrice" name="productPrice" placeholder="Precio del producto..." required>
                            </div>
                            <div class="form-control">
                                <label for="productOfertPrice">Precio oferta</label>
                                <input type="number" id="productOfertPrice" name="productOfertPrice" placeholder="Precio oferta del producto...">
                            </div>
                            <div class="form-control">
                                <label for="productTag">Marca</label>
                                <input type="text" id="productTag" name="productTag" placeholder="Nombre del producto...">
                            </div>
                        </div>
                    </div>
                    <div class="two-rows margin-top">
                        <div class="w-50">
                            <div class="form-control">
                                <label for="productAncho">Ancho</label>
                                <input type="text" id="productAncho" name="productAncho" placeholder="Ancho del producto...">
                            </div>
                            <div class="form-control">
                                <label for="productLargo">Largo</label>
                                <input type="text" id="productLargo" name="productLargo" placeholder="Largo del producto...">
                            </div>
                            <div class="form-control hidden">
                                <label for="productRend">Rendimiento</label>
                                <input type="text" id="productRend" name="productRend" placeholder="Rendimiento del producto...">
                            </div>
                        </div>
                        <div class="w-50">
                            <div class="form-control">
                                <label for="productDetails">Descripción</label>
                                <textarea id="productDetails" name="productDetails" placeholder="Detalles del producto..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="margin-top">
                        <hr class="divider">
                        <div class="form-control">
                            <input type="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>