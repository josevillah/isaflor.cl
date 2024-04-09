<section class="login-container">
    <a href="<?php echo base_url(); ?>" class="brand">
        <img src="<?php echo base_url().'public/img/setup/logo-naranja.png'; ?>" alt="">
    </a>
    <div class="box-container">
        <div class="login-box">
            <h1>Inicia Sesión en tu cuenta. 👋</h1>
            <div class="container-form">
                <form action="" method="post">
                    <div class="form-control">
                        <label for="username">Usuario:</label>
                        <input type="text" id="username" name="username" placeholder="Escribe tu usuario" required>
                        <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                    </div>
                    <div class="form-control">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>
                        <svg width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                    </div>
                    <input type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>
</section>