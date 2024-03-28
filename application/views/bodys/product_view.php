<section class="product-view">
    <div class="product-view-img">
        <img src="<?php echo base_url().$producto['urlimagen']; ?>" alt="" srcset="">
    </div>
    <div class="description-product-view">
        <h1><?php echo $producto['nompro']; ?></h1>
        <h3>SKU: <span><?php echo $producto['codpro']; ?></span></h3>

        <div class="info-price">

            <?php if($producto['medida'] > 0): 

                $precio = $producto['prepro'] / $producto['medida'];

                if($producto['preoferpro'] > 0):
                    $precio_oferta = $producto['preoferpro'] / $producto['medida'];
                endif;
            else:
                $precio = $producto['prepro'];
                if($producto['preoferpro'] > 0):
                    $precio_oferta = $producto['preoferpro'];
                endif;
            endif; ?>

            <?php if($producto['preoferpro'] > 0): ?>

                <?php if($producto['medida'] > 0): ?>
                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                <?php else: ?>
                    <h3 class="product-value-ofert"><?php echo '$' . number_format($precio_oferta, 0, ',', '.'); ?></h3>
                    <h3 class="product-value-line"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                <?php endif; ?>

            <?php else: ?>
                <?php if($producto['medida'] > 0): ?>
                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.')." m<sup>2</sup>"; ?></h3>
                <?php else: ?>
                    <h3 class="product-value"><?php echo '$' . number_format($precio, 0, ',', '.'); ?></h3>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if($producto['medida'] > 0 && $producto['idsubcat'] == 17): ?>
            <h3 class="product-value">Precio Metro Lineal: <?php echo '$' . number_format($producto['prepro'], 0, ',', '.'); ?></h3>
        <?php elseif($producto['medida'] > 0): ?>
                <h3 class="product-value">Precio caja: <?php echo '$' . number_format($producto['prepro'], 0, ',', '.'); ?></h3>
        <?php endif; ?>
        

        <?php if(strtotime($producto['fecharegistro']) > strtotime('-2 months') || $producto['cantidad'] == 0 || $producto['preoferpro'] > 0): ?>
            <div class="product-view-tags">
                <div class="product-tags">
                    <?php if($producto['cantidad'] == 0): ?>
                        <span class="product-sold-out">Agotado</span>
                    <?php else: ?>
                        <?php if(strtotime($producto['fecharegistro']) > strtotime('-2 months')): ?>
                            <span class="product-new">Nuevo</span>
                        <?php endif; ?>
                        <?php if($producto['preoferpro'] > 0): ?>
                            <span class="product-ofert">Oferta</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="product-view-details">
            <div class="details-meds">
                <div class="details-title">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-ruler-measure"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.875 12c.621 0 1.125 .512 1.125 1.143v5.714c0 .631 -.504 1.143 -1.125 1.143h-15.875a1 1 0 0 1 -1 -1v-5.857c0 -.631 .504 -1.143 1.125 -1.143h15.75z" /><path d="M9 12v2" /><path d="M6 12v3" /><path d="M12 12v3" /><path d="M18 12v3" /><path d="M15 12v2" /><path d="M3 3v4" /><path d="M3 5h18" /><path d="M21 3v4" /></svgs>
                    <h3>Detalles de Medidas</h3>
                </div>
                <div class="detail-med">
                    <p>Ancho</p>
                    <p><?php echo $producto['anchpro'] == '' ? 'Sin información': $producto['anchpro'].' cm<sup>2</sup>'; ?></p>
                </div>
                <div class="detail-med">
                    <p>Largo</p>
                    <p><?php echo $producto['largpro'] == '' ? 'Sin información': $producto['largpro'].' cm<sup>2</sup>'; ?></p>
                </div>
                <div class="detail-med">
                    <p>Rendimiento</p>
                    <p><?php echo $producto['medida'] == 0 ? 'Sin información': $producto['medida'].' m<sup>2</sup>'; ?></p>
                </div>
                <div class="detail-med">
                    <p>Marca</p>
                    <p><?php echo $producto['marcapro'] == '' ? 'Sin información': $producto['marcapro']; ?></p>
                </div>
                <div class="details-title">
                    <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-description"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 17h6" /><path d="M9 13h6" /></svgs=>
                    <h3>descripción</h3>
                </div>
                <div class="detail-med">
                    <p class="p-detail"><?php echo $producto['despro'] == '' ? 'Sin información': $producto['despro']; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>