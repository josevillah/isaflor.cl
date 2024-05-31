<section class="relations">
    <h2>Productos relacionados</h2>
    <div class="relations-container">
        <?php
        $j = 0;
        while($j < count($relacionados)):
        ?>
            <a href="<?php echo base_url("index.php/productos/viewProduct/".$relacionados[$j]['id']); ?>" class="product-relation">
                <div class="img-relation">
                    <img src="<?php echo base_url().$relacionados[$j]['urlimagen']; ?>" alt="">
                </div>
                <div class="detail-relation">
                    <h2><?php echo $relacionados[$j]['nompro']; ?></h2>
                    
                        <?php if($relacionados[$j]['medida'] > 0): 
                            $precio = $relacionados[$j]['prepro'] / $relacionados[$j]['medida'];

                            if($relacionados[$j]['preoferpro'] > 0):
                                $precio_oferta = $relacionados[$j]['preoferpro'] / $relacionados[$j]['medida'];
                            endif;
                            else:
                            $precio = $relacionados[$j]['prepro'];
                            if($relacionados[$j]['preoferpro'] > 0):
                                $precio_oferta = $relacionados[$j]['preoferpro'];
                            endif;
                        endif; ?>

                        <?php if($relacionados[$j]['preoferpro'] > 0): ?>

                            <?php if($relacionados[$j]['medida'] > 0): ?>
                                <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                                <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                            <?php else: ?>
                                <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.'); ?></h3>
                                <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php if($relacionados[$j]['medida'] > 0): ?>
                                <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                            <?php else: ?>
                                <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                            <?php endif; ?>
                        <?php endif; ?>
                </div>

                <?php if($relacionados[$j]['medida'] > 0 && $relacionados[$j]['idsubcat'] == 17): ?>
                    <div class="box-value">
                        <h3 class="product-value">Precio Metro Lineal: <?php echo '$' . number_format($relacionados[$j]['prepro'], 0, ',', '.'); ?></h3>
                    </div>
                <?php elseif($relacionados[$j]['medida'] > 0): ?>
                    <div class="box-value">
                        <h3 class="product-value">Precio caja: <?php echo '$' . number_format($relacionados[$j]['prepro'], 0, ',', '.'); ?></h3>
                    </div>
                <?php endif; ?>
                    
                <h5 class="sku">SKU: <?php echo $relacionados[$j]['codpro']; ?></h5>

                <div class="product-tags">
                    <?php if($relacionados[$j]['cantidad'] == 0): ?>
                        <span class="product-sold-out">Agotado</span>
                    <?php else: ?>
                        <?php if(strtotime($relacionados[$j]['fecharegistro']) > strtotime('-2 months')): ?>
                            <span class="product-new">Nuevo</span>
                        <?php endif; ?>
                        <?php if($relacionados[$j]['preoferpro'] > 0): ?>
                            <span class="product-ofert">Oferta</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </a>
        <?php 
        $j++;
        endwhile;
        ?>
    </div>
</section>

<!-- <?php var_dump($relacionados[0]);?> -->