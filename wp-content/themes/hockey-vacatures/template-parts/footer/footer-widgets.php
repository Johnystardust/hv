<?php
/**
 * Footer Widgets
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

if(is_active_sidebar('footer')): ?>
    <aside class="widget-area">
        <div class="row">
            <?php dynamic_sidebar('footer'); ?>

            <?php if(get_theme_mod('footer_company_widget')): ?>
                <div class="col-md-4">
                    <h5 class="widget-title"><?php echo get_theme_mod('footer_company_title'); ?></h5>
                    <?php echo get_theme_mod('footer_company_text'); ?>
                </div>
            <?php endif; ?>
        </div>
    </aside>
<?php endif; ?>