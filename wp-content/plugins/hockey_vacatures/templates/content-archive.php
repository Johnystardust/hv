<?php

/**
 * Archive Item Template for the Vacatures Custom Post Type
 *
 * This file is used to markup the archive view for the vacatures custom post type.
 *
 * @link       http://timvanderslik.nl
 * @since      1.0.0
 *
 * @package    Hockey_vacatures
 * @subpackage Hockey_vacatures/public/partials
 */
?>
<?php global $post; ?>
<?php $vacature = HV_Vacature::find($post->ID); ?>

<div class="vacature-item col-12 px-0">
    <?php if($vacature->show_in_review_notice()): ?>
        <p class="review-notice"><?php echo __('De vacature staat klaar voor controle zodra deze gedaan is zal de vacature openbaar zijn. De vacature is nu alleen voor u zichtbaar.', 'hockey_vacatures'); ?></p>
    <?php elseif($vacature->show_flagged_notice()): ?>
        <p class="flagged-notice"><?php echo __('De vacature is gemarkeerd voor controle omdat gebruikers deze aanstootgevend vonden. De vacature is alleen voor u zichtbaar.', 'hockey_vacatures'); ?></p>
    <?php endif; ?>

    <h4 class="title">
        <a href="<?php echo get_the_permalink(); ?>">
            <?php echo get_the_title(); ?>
        </a>
    </h4>
    <h5 class="sub-line">
        <strong><?php echo get_the_author(); ?></strong>
        <span>- <?php echo $vacature->city; ?></span>
    </h5>
    <div class="spacer small"></div>
    <?php if (function_exists('the_views')): ?>
        <h5 class="sub-line">
            <span><?php echo __('Aantal keer bekeken', TEXTDOMAIN); ?> - <?php the_views(); ?></span>
        </h5>
    <?php endif; ?>
    <p><?php echo wp_trim_words(get_the_content(), 25); ?></p>
    <ul class="vacature-info row mt-2">
        <?php if ($function_term = get_term_by('id', $vacature->vacature_cat, 'vacature_category')): ?>
            <li class="col-6 col-md-3">
                <i class="fa fa-user"></i>
                <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                <?php echo $function_term->name; ?>
            </li>
        <?php endif; ?>
        <li class="col-6 col-md-3">
            <?php echo $vacature->get_vacature_gender_icon(); ?>
            <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
            <?php echo $vacature->get_vacature_gender() ?>
        </li>
        <li class="col-6 col-md-3">
            <i class="fa fa-user"></i>
            <strong><?php echo __('Leeftijd:', TEXTDOMAIN); ?></strong>
            <?php echo ucfirst($vacature->age); ?>
        </li>
        <li class="col-6 col-md-3">
            <i class="fa fa-user"></i>
            <strong><?php echo __('Veld/zaal:', TEXTDOMAIN); ?></strong>
            <?php echo $vacature->get_vacature_field(); ?>
        </li>
    </ul>
    <div class="btn-set">
        <a class="btn btn-primary"
           href="<?php echo get_the_permalink(); ?>"><?php echo __('Meer informatie', TEXTDOMAIN); ?></a>
        <?php if (!empty($vacature->get_vacature_author_email())): ?>
            <a class="btn btn-border"
               href="mailto:<?php echo $vacature->get_vacature_author_email(); ?>"><?php echo __('Solliciteer direct', TEXTDOMAIN); ?></a>
        <?php endif; ?>
    </div>
</div>
