<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Project ITE1805</title>
</head>
<body>

    <?php
    include_once('../Classes/user.php');

    #Initializing the member method
    $object = new User();
    $object->Member();
    ?>


</body>
</html>