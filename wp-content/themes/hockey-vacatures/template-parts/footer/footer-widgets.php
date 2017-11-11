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
        </div>
    </aside>
<?php endif; ?>