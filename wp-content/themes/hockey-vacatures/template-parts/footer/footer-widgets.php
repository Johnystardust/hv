<?php
/**
 * Footer Widgets
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */

if(is_active_sidebar('footer')): ?>
    <div class="row">
        <?php dynamic_sidebar('footer'); ?>
    </div>
<?php endif; ?>