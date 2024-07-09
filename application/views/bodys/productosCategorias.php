<section class="container-list-products">
    <div class="list-products">
        <?php 
            $i = 0;
            while($i < count($productos)): ?>
            <a href="<?php echo base_url("index.php/productos/viewProduct/".$productos[$i]['id']); ?>" class="product-container">
                <div class="product">
                    <!-- Estado del producto -->
                    <div class="product-tags">
                        <?php if($productos[$i]['cantidad'] == 0): ?>
                            <span class="product-sold-out">Agotado</span>
                        <?php else: ?>
                            <?php if(strtotime($productos[$i]['fecharegistro']) > strtotime('-2 months')): ?>
                                <span class="product-new">Nuevo</span>
                            <?php endif; ?>
                            <?php if($productos[$i]['preoferpro'] > 0): ?>
                                <span class="product-ofert">Oferta</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Imagen del producto -->
                    <div class="product-image">
                        <img src="<?php echo base_url().$productos[$i]['urlimagen'].'?v='.$fecha_actual; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $productos[$i]['nompro']; ?></h3>
                        <div class="product-price-container">
                            <?php if($productos[$i]['medida'] > 0): 
                                $precio = $productos[$i]['prepro'] / $productos[$i]['medida'];

                                if($productos[$i]['preoferpro'] > 0):
                                    $precio_oferta = $productos[$i]['preoferpro'] / $productos[$i]['medida'];
                                endif;
                                else:
                                $precio = $productos[$i]['prepro'];
                                if($productos[$i]['preoferpro'] > 0):
                                    $precio_oferta = $productos[$i]['preoferpro'];
                                endif;
                            endif; ?>

                            <?php if($productos[$i]['preoferpro'] > 0): ?>

                                <?php if($productos[$i]['medida'] > 0): ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.'); ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>

                            <?php else: ?>
                                <?php if($productos[$i]['medida'] > 0): ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                        
                        <?php if($productos[$i]['medida'] > 0 && $productos[$i]['idsubcat'] == 17): ?>
                            <div class="box-value">
                                <h3 class="product-value">Precio Metro Lineal: <?php echo '$' . number_format($productos[$i]['prepro'], 0, ',', '.'); ?></h3>
                            </div>
                        <?php elseif($productos[$i]['medida'] > 0): ?>
                            <div class="box-value">
                                <h3 class="product-value">Precio caja: <?php echo '$' . number_format($productos[$i]['prepro'], 0, ',', '.'); ?></h3>
                            </div>
                        <?php endif; ?>

                        <h5>SKU: <?php echo $productos[$i]['codpro']; ?></h5>
                    </div>
                </div>
            </a>
            <?php 
                $i++;
        endwhile; ?>
    </div>
</section>