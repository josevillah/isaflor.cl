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
                        <img src="<?php echo base_url().$productos[$i]['urlimagen']; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $productos[$i]['nompro']; ?></h3>
                        <div class="product-price-container">
                            <?php if($productos[$i]['preoferpro'] > 0): ?>
                                <p class="product-price-ofert">
                                    <?php echo '$' . number_format($productos[$i]['preoferpro'], 0, ',', '.'); ?>
                                    <span class="product-ofert">
                                        <?php $descuento = (($productos[$i]['prepro'] - $productos[$i]['preoferpro']) / $productos[$i]['prepro']) * 100;?>
                                        <?php echo round($descuento, 2) . "%"; ?>
                                    </span>
                                </p>
                                <p class="product-price">
                                    <?php echo '$' . number_format($productos[$i]['prepro'], 0, ',', '.'); ?>
                                </p>
                                <?php else: ?>
                                    <p class="product-price-ofert">
                                        <?php echo '$' . number_format($productos[$i]['prepro'], 0, ',', '.'); ?>
                                    </p>
                            <?php endif; ?>
                        </div>
                        <h5>SKU: <?php echo $productos[$i]['codpro']; ?></h5>
                    </div>
                </div>
            </a>
            <?php 
                $i++;
        endwhile; ?>
    </div>
</section>