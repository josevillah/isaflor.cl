<section class="category-one">
    <h2><?php echo $categoryOne[0]['nombre_categoria']; ?></h2>
    <div class="product-list">
        <?php 
            $i = 0;
            while($i < count($categoryOne)): ?>
            <a href="<?php echo base_url("index.php/productos/viewProduct/".$categoryOne[$i]['id_producto']); ?>" class="product-container">
                <div class="product">
                    <!-- Estado del producto -->
                    <div class="product-tags">
                        <?php if($categoryOne[$i]['cantidad'] == 0): ?>
                            <span class="product-sold-out">Agotado</span>
                        <?php else: ?>
                            <?php if(strtotime($categoryOne[$i]['fecha']) > strtotime('-2 months')): ?>
                                <span class="product-new">Nuevo</span>
                            <?php endif; ?>
                            <?php if($categoryOne[$i]['precio_oferta'] > 0): ?>
                                <span class="product-ofert">Oferta</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Imagen del producto -->
                    <div class="product-image">
                        <img src="<?php echo base_url().$categoryOne[$i]['url_imagen_producto']; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $categoryOne[$i]['nombre_producto']; ?></h3>
                        <div class="product-price-container">
                            <?php if($categoryOne[$i]['medida'] > 0): 
                                $precio = $categoryOne[$i]['precio_producto'] / $categoryOne[$i]['medida'];

                                if($categoryOne[$i]['precio_oferta'] > 0):
                                    $precio_oferta = $categoryOne[$i]['precio_oferta'] / $categoryOne[$i]['medida'];
                                endif;
                                else:
                                $precio = $categoryOne[$i]['precio_producto'];
                                if($categoryOne[$i]['precio_oferta'] > 0):
                                    $precio_oferta = $categoryOne[$i]['precio_oferta'];
                                endif;
                            endif; ?>

                            <?php if($categoryOne[$i]['precio_oferta'] > 0): ?>

                                <?php if($categoryOne[$i]['medida'] > 0): ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.'); ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>

                            <?php else: ?>
                                <?php if($categoryOne[$i]['medida'] > 0): ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <?php if($categoryOne[$i]['medida'] > 0 && $categoryOne[$i]['id_categoria'] == 17): ?>
                            <div class="box-value">
                                <h3 class="product-value">Precio Metro Lineal: <?php echo '$' . number_format($categoryOne[$i]['precio_producto'], 0, ',', '.'); ?></h3>
                            </div>
                        <?php elseif($categoryOne[$i]['medida'] > 0): ?>
                            <div class="box-value">
                                <h3 class="product-value">Precio caja: <?php echo '$' . number_format($categoryOne[$i]['precio_producto'], 0, ',', '.'); ?></h3>
                            </div>
                        <?php endif; ?>

                        <h5>SKU: <?php echo $categoryOne[$i]['codigo_producto']; ?></h5>
                    </div>
                </div>
            </a>
            <?php 
                $i++;
        endwhile; ?>
    </div>
</section>