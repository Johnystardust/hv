<?php
if(is_archive()){
    if(is_active_sidebar('archive_sidebar')){
        dynamic_sidebar('archive_sidebar');
    }
} elseif (is_single()){
    if(is_active_sidebar('single_sidebar')){
        dynamic_sidebar('single_sidebar');
    }
} else{
    if(is_active_sidebar('sidebar')){
        dynamic_sidebar('sidebar');
    }
}