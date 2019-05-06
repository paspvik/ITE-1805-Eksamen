


<?php
require 'file_uploader/auth_pdo.php'; 
require 'file_uploader/file_functions.php'; 
?>



<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

}

AccessSingleFile($db, $view);
?>