<div id="hv-side-panel" <?php echo ( isset( $_GET['login'] ) == true ) ? 'class="active"' : ''; ?>>
    <div class="hv-side-panel-inner slideInRight animated p-4">
        <div class="row">
            <div class="col-12">
                <?php $user_id = get_current_user_id(); ?>
                <?php $user_data = get_userdata( $user_id ); ?>

                <!--                --><?php
                //                $additional_data = get_user_meta(get_current_user_id(), 'hv_user_data', true);
                //                var_dump($additional_data);
                //                ?>

                <h3><?php echo __( 'Hallo ', 'hockey_vacatures' ) . $user_data->first_name; ?></h3>
            </div>

            <div class="col-12 mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="widget widget_nav_menu">
                            <ul class="mt-3">
                                <li><a class="hv-side-panel-tab" href="<?php echo get_permalink( get_page_by_path( 'nieuwe-vacature' ) ); ?>"><?php echo __( 'Nieuwe vacature maken', 'hockey_vacatures' ); ?></a></li>
<!--                                <li><a class="hv-side-panel-tab user-vacatures" href="#user_vacatures">--><?php //echo __( 'Mijn vacatures', 'hockey_vacatures' ); ?><!--</a></li>--> <!-- TODO: MIJN VACATURES LINK MAKEN -->
                                <li><a class="hv-side-panel-tab" href="<?php echo add_query_arg( 'id', $user_id, get_permalink( get_page_by_path( 'profiel-bewerken' ) ) ); ?>"><?php echo __( 'Profiel bewerken', 'hockey_vacatures' ); ?></a></li>
<!--                                <li><a class="hv-side-panel-tab" href="#">--><?php //echo __( 'Tegoed kopen', 'hockey_vacatures' ); ?><!--</a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="ajax-contents col-12 mt-5">

            </div>


        </div>
    </div>
</div>