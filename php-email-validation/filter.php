<?php
// filter_var($email, FILTER_VALIDATE_EMAIL)
// will return true if the $email looks like an email address

// Validating a variable:
$email = 'foo@com.com';
var_dump(filter_var($email, FILTER_VALIDATE_EMAIL));

// You can also use $_POST array directly like this:
var_dump(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));

// Example:
if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	echo 'email set, but invalid address';
}
