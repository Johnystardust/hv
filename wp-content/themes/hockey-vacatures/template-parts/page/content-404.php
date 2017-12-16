<?php
/**
 * Template part for displaying page content in 404.php
 *
 * Case: Hockey Vacatures
 * Author: Tim van der Slik
 * Website: timvanderslik.nl
 */
?>

<article id="post-<?php the_ID(); ?>" >
    <div class="entry-content">
        <?php // TODO: FIX THIS IN CUSTOMIZER AND STYLE ?>
        <h2>Sorry, we kunnen deze pagina niet meer vinden</h2>
        <p>We hebben ons best gedaan, maar het lijkt erop dat deze pagina niet (meer) bestaat of misschien verhuisd is. Je kunt natuurlijk altijd naar de homepage of de zoekfunctie gebruiken.</p>
        <?php get_search_form(); ?>
    </div>
</article>
