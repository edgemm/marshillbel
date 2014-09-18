<?php

remove_action( 'admin_init', 'send_frame_options_header', 10, 0 );
remove_action( 'login_init', 'send_frame_options_header', 10, 0 );

?>