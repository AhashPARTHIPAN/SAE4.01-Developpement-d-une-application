<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);
require "view_begin.php"; ?>


<h1> 
    <?php echo $title ?> 
</h1>

<p>   
    <?php echo $message ?>
</p>


<?php require "view_end.php"; ?>
