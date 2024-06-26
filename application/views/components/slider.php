<section class="body">
    <div class="slider-container">
        <div class="slider">
            <?php if($mes_dia_actual <= '30-06'): ?>
                <img src="<?php echo base_url("public/img/banner/banner7.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
                <img src="<?php echo base_url("public/img/banner/banner8.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
            <?php endif; ?>
            <img src="<?php echo base_url("public/img/banner/banner1.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
            <img src="<?php echo base_url("public/img/banner/banner2.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
            <img src="<?php echo base_url("public/img/banner/banner3.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
            <img src="<?php echo base_url("public/img/banner/banner4.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
            <img src="<?php echo base_url("public/img/banner/banner5.webp").'?'.$fecha_actual; ?>" alt="" srcset="">
        </div>
        <div class="slider-buttons">
            <button class="button-left">
                <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
            </button>
            <button class="button-right">
                <svg width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
            </button>
        </div>
    </div>
</section>