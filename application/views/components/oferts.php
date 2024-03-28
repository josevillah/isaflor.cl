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
                        <img src="<?php echo base_url().$ofertas[$i]['urlimagen']; ?>" alt="">
                    </div>
                    <!-- Información del producto -->
                    <div class="product-info">
                        <h3><?php echo $ofertas[$i]['nompro']; ?></h3>
                        <div class="product-price-container">
                            <?php if($ofertas[$i]['preoferpro'] > 0): ?>
                                <p class="product-price-ofert">
                                    <?php echo '$' . number_format($ofertas[$i]['preoferpro'], 0, ',', '.'); ?>
                                    <span class="product-ofert">
                                        <?php $descuento = (($ofertas[$i]['prepro'] - $ofertas[$i]['preoferpro']) / $ofertas[$i]['prepro']) * 100;?>
                                        <?php echo round($descuento, 2) . "%"; ?>
                                    </span>
                                </p>
                                <p class="product-price">
                                    <?php echo '$' . number_format($ofertas[$i]['prepro'], 0, ',', '.'); ?>
                                </p>
                                <?php else: ?>
                                    <p class="product-price-ofert">
                                        <?php echo '$' . number_format($ofertas[$i]['prepro'], 0, ',', '.'); ?>
                                    </p>
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