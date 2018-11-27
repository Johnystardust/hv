<?php global $post; ?>
<?php $vacature = HV_Vacature::find($post->ID); ?>

<h2 class="font-weight-bold"><?php echo $vacature->title; ?></h2>
<strong class="mt-3"><?php echo __('Geplaatst:', TEXTDOMAIN) . ' ' . get_the_date('d-m-Y'); ?></strong>
<div class="spacer"></div>
<div class="row mb-3">
    <div class="col-12">
        <strong class="d-block mb-3"><?php echo __('Vacature informatie', 'hockey_vacatures'); ?></strong>
        <ul class="vacature-info">
            <?php if ($function_term = get_term_by('id', $vacature->vacature_cat, 'vacature_category')): ?>
                <li>
                    <i class="fa fa-user"></i>
                    <strong><?php echo __('Functie:', TEXTDOMAIN); ?></strong>
                    <?php echo $function_term->name; ?>
                </li>
            <?php endif; ?>
            <li>
                <i class="fa fa-user"></i>
                <strong><?php echo __('Geslacht:', TEXTDOMAIN); ?></strong>
                <?php echo $vacature->get_vacature_gender() ?>
            </li>
            <li>
                <i class="fa fa-user"></i>
                <strong><?php echo __('Leeftijd:', TEXTDOMAIN); ?></strong>
                <?php echo ucfirst($vacature->age); ?>
            </li>
            <li>
                <i class="fa fa-user"></i>
                <strong><?php echo __('Veld/zaal:', TEXTDOMAIN); ?></strong>
                <?php echo $vacature->get_vacature_field(); ?>
            </li>
        </ul>
    </div>
</div>

<div class="the-content">
    <?php echo $vacature->the_content; ?>
</div>

<div class="row mt-5">
    <div class="col-12">
        <strong class="d-block mb-3"><?php echo __('Contact informatie', 'hockey_vacatures'); ?></strong>
        <ul class="vacature-data">
            <li>
                <i class="fa fa-map-marker"></i>
                <strong><?php echo __('Plaats:', TEXTDOMAIN); ?></strong>
                <?php echo $vacature->city; ?>
            </li>
            <li>
                <i class="fa fa-globe"></i>
                <strong><?php echo __('Provincie:', TEXTDOMAIN); ?></strong>
                <?php echo $vacature->province; ?>
            </li>
            <?php if (!empty($vacature->get_vacature_author_email())): ?>
                <li>
                    <i class="fas fa-envelope"></i>
                    <strong><?php echo __('Mail:', TEXTDOMAIN); ?></strong>
                    <?php echo $vacature->get_vacature_author_email(); ?>
                </li>
            <?php endif; ?>
            <?php if (!empty($vacature->get_vacature_author_meta_by_key('tel'))): ?>
                <li>
                    <i class="fa fa-phone"></i>
                    <strong><?php echo __('Tel:', TEXTDOMAIN); ?></strong>
                    <?php echo $vacature->get_vacature_author_meta_by_key('tel'); ?>
                </li>
            <?php endif; ?>
            <?php if (!empty($vacature->get_vacature_author_url())): ?>
                <li>
                    <i class="fa fa-external-link"></i>
                    <strong><?php echo __('Website:', TEXTDOMAIN); ?></strong>
                    <?php echo $vacature->get_vacature_author_url(); ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php if (!empty($vacature->get_vacature_author_email())): ?>
    <div class="btn-set mt-3">
        <a href="mailto:<?php echo $vacature->get_vacature_author_email(); ?>"
           class="btn btn-primary"><?php echo __('Solliciteren', TEXTDOMAIN); ?></a>
    </div>
<?php endif; ?>

<?php //TODO: Onclick flag this vacature and after * flags set it to inacctive and mail the user. ?>
<?php //TODO: If the user clicks the link send mail to admins ?>
<?php //TODO: Add the * ass option in the backend ?>
<?php if (true == false): ?>
    <div class="send-notification">
        <a id="hv-flag-vacature" href="#" data-id="<?php echo $post->ID; ?>"
           data-nonce="<?php echo wp_create_nonce('vacature_flag_nonce'); ?>"><?php echo __('Vacature niet oke? Laat het ons weten!', TEXTDOMAIN); ?></a>
    </div>
<?php endif; ?>

<?php $related = $vacature->get_related_vacatures(); ?>
<?php if(count($related) >= 1): ?>
<div id="related-vacatures" class="row mt-5">
    <div class="col-12 mt-5 mb-5">
        <h4 class="title"><?php echo __('Gerelateerde vacatures', 'hockey_vactures'); ?></h4>
    </div>

    <?php foreach ($related as $related_post): ?>
        <?php include(HV_ABSPATH . 'templates/content-related.php'); ?>
    <?php endforeach; ?>
</div>
<?php endif; ?>