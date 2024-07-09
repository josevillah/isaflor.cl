<section class="oferts">
    <div class="ofert-title">
        <h2>Nuestras Ofertas</h2>
        <a href="<?php echo base_url("index.php/productos/viewOferts/?page=1"); ?>">
            Ver mas
        </a>
    </div>
    <div class="product-list">
        <?php 
            $i = 0;
            while($i < count($ofertas)): ?>
            <a href="<?php echo base_url("index.php/productos/viewProduct/".$ofertas[$i]['id']); ?>" class="product-container">
                <div class="product">
                    <!-- Estado del producto -->
                    <div class="product-tags">
                        <?php if($ofertas[$i]['cantidad'] == 0): ?>
                            <span class="product-sold-out">Agotado</span>
                        <?php else: ?>
                            <?php if(strtotime($ofertas[$i]['fecharegistro']) > strtotime('-2 months')): ?>
                                <span class="product-new">Nuevo</span>
                            <?php endif; ?>
                            <?php if($ofertas[$i]['preoferpro'] > 0): ?>
                                <span class="product-ofert">Oferta</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Imagen del producto -->
                    <div class="product-image">
                        <img src="<?php echo base_url().$ofertas[$i]['urlimagen'].'?v='.$fecha_actual; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $ofertas[$i]['nompro']; ?></h3>
                        <div class="product-price-container">
                            <?php if($ofertas[$i]['medida'] > 0): 
                                $precio = $ofertas[$i]['prepro'] / $ofertas[$i]['medida'];

                                if($ofertas[$i]['preoferpro'] > 0):
                                    $precio_oferta = $ofertas[$i]['preoferpro'] / $ofertas[$i]['medida'];
                                endif;
                                else:
                                $precio = $ofertas[$i]['prepro'];
                                if($ofertas[$i]['preoferpro'] > 0):
                                    $precio_oferta = $ofertas[$i]['preoferpro'];
                                endif;
                            endif; ?>

                            <?php if($ofertas[$i]['preoferpro'] > 0): ?>

                                <?php if($ofertas[$i]['medida'] > 0): ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.'); ?></h3>
                                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>

                            <?php else: ?>
                                <?php if($ofertas[$i]['medida'] > 0): ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <?php else: ?>
                                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <h5>SKU: <?php echo $ofertas[$i]['codpro']; ?></h5>
                    </div>
                </div>
            </a>
            <?php 
                $i++;
        endwhile; ?>
    </div>
</section>