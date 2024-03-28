<nav class="header-bar">
    <div class="container">
        <div class="container-logo">
            <div class="logo">
                <a href="<?php echo base_url(); ?>">
                    <img src="<?php echo base_url("public/img/setup/logo-naranja.png"); ?>" alt="Isaflor">
                </a>
            </div>
        </div>
        <div class="menu">
            <div class="menu-toggle">
                <button class="btn-bar">
                    <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="20" y2="12" /><line x1="4" y1="18" x2="20" y2="18" /></svg>
                    Categorías
                </button>
            </div>
            <div class="search-bar">
                <div class="form-control">
                    <input type="text" name="SearchProduct" placeholder="Buscar...">
                    <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                </div>
                <div class="search-container">
                    <div class="spinner"></div>
                    <div class="search-results"></div>
                </div>
            </div>
        </div>
        <div class="menu-links">
            <ul>
                <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
                <li><a href="#">Nosotros</a></li>
                <li><a href="<?php echo base_url().'index.php/contact/' ?>">Contacto</a></li>
                <!-- <li class="cart">
                    <a href="<?php echo base_url(); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>
                        <span class="active"></span>
                    </a>
                </li> -->
            </ul>
        </div>
        <div class="menu-toggle-movil">
            <button class="btn-bar">
                <svg width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="6" x2="20" y2="6" /><line x1="4" y1="12" x2="20" y2="12" /><line x1="4" y1="18" x2="20" y2="18" /></svg>
            </button>
        </div>
    </div>
</nav>

<section class="container-menu-movil">
    <div class="menu-links-movil">
        <div class="header-menu">
            <div class="container-brand">
                <div class="logo">
                    <a>
                        <img src="<?php echo base_url("public/img/setup/logo-blanco.png"); ?>" alt="Isaflor">
                    </a>
                </div>
            </div>
            <div class="container-close-button">
                <button class="close-menu">
                    <svg width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                </button>
            </div>
        </div>
        <div class="container-menu">
            <ul class="link-movile">
                <li>
                    <a href="<?php echo base_url(); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0" /><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" /><path d="M5 21l0 -10.15" /><path d="M19 21l0 -10.15" /><path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" /></svg>
                        Nosotros
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url().'index.php/contact/' ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" /><path d="M10 16h6" /><path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 8h3" /><path d="M4 12h3" /><path d="M4 16h3" /></svg>
                        Contacto
                    </a>
                </li>
                <li>
                    <a class="btn-categories-movile" href="<?php echo base_url(); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h6v6h-6z" /><path d="M14 4h6v6h-6z" /><path d="M4 14h6v6h-6z" /><path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
                        Categorías
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="container-menu-categories">
    <div class="menu-categories">
        <div class="header-menu">
            <div class="container-brand">
                <div class="logo">
                    <a>
                        <img src="<?php echo base_url("public/img/setup/logo-blanco.png"); ?>" alt="Isaflor">
                    </a>
                </div>
            </div>
            <div class="container-close-button">
                <button class="close-menu">
                    <svg width="28" height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                </button>
            </div>
        </div>
        <div class="container-menu">
            <ul>
                <?php for($i = 0; $i < count($categorias); $i++): ?>
                    <li class="parent-categories" data-id="<?php echo $categorias[$i]['id']; ?>">
                        <div>
                            <?php echo $categorias[$i]['nombre']; ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </div>
                        <ul class="dropdown-container"></ul>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</section>