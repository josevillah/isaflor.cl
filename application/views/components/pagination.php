<nav class="pagination">
    <ul class="pagination-container">
        <li class="pagination-btn-prev">
            <a class="<?php echo ($_GET['page']-1) < 1 ? 'disable': ''; ?>" href="<?php echo '?page='.($_GET['page']-1); ?>">
                Anterior
            </a>
        </li>

        <?php for($i = 0; $i < $numero_paginas; $i++): ?>
            <li class="pagination-item">
                <a class="<?php echo $_GET['page'] == $i+1 ? 'active': ''; ?>" href="<?php echo '?page='.($i+1); ?>">
                    <?php echo $i + 1; ?>
                </a>
            </li>
        <?php endfor; ?>

        <li class="pagination-btn-next">
            <a class="<?php echo ($_GET['page']+1) > $numero_paginas ? 'disable': ''; ?>" href="<?php echo '?page='.($_GET['page']+1); ?>">
                Siguiente
            </a>
        </li>
    </ul>

    <ul class="pagination-movile">
        <li class="pagination-btn-prev-movil">
            <a class="<?php echo ($_GET['page']-1) < 1 ? 'disable': ''; ?>" href="<?php echo '?page='.($_GET['page']-1); ?>">
                Anterior
            </a>
        </li>

        <li class="pagination-btn-next-movil">
            <a class="<?php echo ($_GET['page']+1) > $numero_paginas ? 'disable': ''; ?>" href="<?php echo '?page='.($_GET['page']+1); ?>">
                Siguiente
            </a>
        </li>
    </ul>

    <ul class="pagination-movile-container">
        <?php for($i = 0; $i < $numero_paginas; $i++): ?>
            <li class="pagination-item">
                <a class="<?php echo $_GET['page'] == $i+1 ? 'active': ''; ?>" href="<?php echo '?page='.($i+1); ?>">
                    <?php echo $i + 1; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
