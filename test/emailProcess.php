<?php echo "Thanks," ?> <?php
@extract($_POST);
$sub = "Form feedback";
$name = stripslashes($name);
$email = stripslashes($email);
mail('admin@your-domain.com', $sub, "$name $email", "From: $name <admin@your-domain.com>");
echo stripslashes($name);
?> , we will drop you a line shortly.
