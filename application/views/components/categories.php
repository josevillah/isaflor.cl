<section class="categories">
    <div class="categories-container">
        <div class="categories-title">
            <h2>Categorías</h2>
        </div>
        <div class="categories-content">
            <?php foreach ($destacadas as $destacada): ?>
                <div class="category">
                    <a href="<?php echo base_url("index.php/categorias/viewCategoria/".$destacada['id']).'?page=1'; ?>" class="container-img">
                        <div class="nameCategory-container">
                            <span class="categoryName"><?php echo $destacada['nombre'] ?></span>
                        </div>
                        <img src="<?= base_url() . $destacada['url_imagen_categoria']; ?>" alt="<?= $destacada['nombre']; ?>">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>