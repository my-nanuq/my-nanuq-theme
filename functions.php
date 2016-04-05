<?php

if (!defined('WPINC')) {
    echo "What do you think you're doing ??";
    error_log("Direct inclusion...");
    die;
}

if (!is_admin()) {
    include('my-nanuq-public.php');
}

if (is_admin()) {
    include('my-nanuq-admin.php');
}
