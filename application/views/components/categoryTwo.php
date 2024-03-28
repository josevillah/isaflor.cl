<section class="category-one">
    <h2><?php echo $categoryTwo[0]['nombre_categoria']; ?></h2>
    <div class="product-list">
        <?php 
            $i = 0;
            while($i < count($categoryTwo)): ?>
            <a href="<?php echo base_url("index.php/productos/viewProduct/".$categoryTwo[$i]['id_producto']); ?>" class="product-container">
                <div class="product">
                    <!-- Estado del producto -->
                    <div class="product-tags">
                        <?php if($categoryTwo[$i]['cantidad'] == 0): ?>
                            <span class="product-sold-out">Agotado</span>
                        <?php else: ?>
                            <?php if(strtotime($categoryTwo[$i]['fecha']) > strtotime('-2 months')): ?>
                                <span class="product-new">Nuevo</span>
                            <?php endif; ?>
                            <?php if($categoryTwo[$i]['precio_oferta'] > 0): ?>
                                <span class="product-ofert">Oferta</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Imagen del producto -->
                    <div class="product-image">
                        <img src="<?php echo base_url().$categoryTwo[$i]['url_imagen_producto']; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $categoryTwo[$i]['nombre_producto']; ?></h3>
                        <div class="product-price-container">
                            <?php if($categoryTwo[$i]['precio_oferta'] > 0): ?>
                                <p class="product-price-ofert">
                                    <?php echo '$' . number_format($categoryTwo[$i]['precio_oferta'], 0, ',', '.'); ?>
                                    <span class="product-ofert">
                                        <?php $descuento = (($categoryTwo[$i]['precio_producto'] - $categoryTwo[$i]['precio_oferta']) / $categoryTwo[$i]['precio_producto']) * 100;?>
                                        <?php echo round($descuento, 2) . "%"; ?>
                                    </span>
                                </p>
                                <p class="product-price">
                                    <?php echo '$' . number_format($categoryTwo[$i]['precio_producto'], 0, ',', '.'); ?>
                                </p>
                                <?php else: ?>
                                    <p class="product-price-ofert">
                                        <?php echo '$' . number_format($categoryTwo[$i]['precio_producto'], 0, ',', '.'); ?>
                                    </p>
                            <?php endif; ?>
                        </div>
                        <h5>SKU: <?php echo $categoryTwo[$i]['codigo_producto']; ?></h5>
                    </div>
                </div>
            </a>
            <?php 
                $i++;
        endwhile; ?>
    </div>
</section>