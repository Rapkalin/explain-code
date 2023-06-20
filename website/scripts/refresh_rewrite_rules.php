<?php
// Load WP context
require_once("../wordpress-core/wp-load.php");
flush_rewrite_rules();
echo "rewrite rules cache cleaned";
