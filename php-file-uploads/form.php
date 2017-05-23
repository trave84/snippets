<?php
// will put uploaded images to this dir, needs to be writable
$upload_dir = './images';

// array of allowed types mapped to file extensions
$allowed_types = array(
	'image/jpeg' => 'jpg',
	'image/png' => 'png',
);

function check_and_move_file($formfile, $allowed, $upload_dir)
{
	// Need to check the type of the file so that bad guys don't upload .php files
	$type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $formfile['tmp_name']);

	if (!isset($allowed[$type])) {
		return false;
	}

	// Now we need to rebuild the filename so that the extension comes from us not from the user, they might be a bad guy, hahahaha
	// Prepare the basename of the file, thats the filename without an extension (foo.bar.jpg => foo.bar)
	$basename = pathinfo(basename($formfile['name']), PATHINFO_FILENAME);

	// Sanitize the name, remove any extra extensions it might have by replacing dots with underscores (foo.bar => foo_bar)
	$basename = str_replace('.', '_', $basename);

	// This is the resilting filename complete with an script-provided extension
	$upload_file = $upload_dir . '/' . $basename . '.' . $allowed[$type];

	// Need to move the file to the location, otherwise it will be automagically deleted by PHP
	// Do not use copy() for copying uploaded files. Never ever.
	if (move_uploaded_file($formfile['tmp_name'], $upload_file)) {
		return $upload_file;
	} else {
		return false;
	}
}

if ($_POST) {
	if (!is_writable($upload_dir)) {
		echo 'Cannot write to ' . $upload_dir;
	}
	$result = check_and_move_file($_FILES['imagefield'], $allowed_types, $upload_dir);
	if ($result !== false) {
		header('Location: form.php?file=' . $result);
	} else {
		echo 'ERROR!';
	}
} elseif (isset($_GET['file'])) {
	echo 'Your image is now in ' . $upload_dir . '<br>';
	echo 'The path to your file is ' . htmlspecialchars($_GET['file']) . ', you might want to store it to a database or something<br>';
	echo 'And this is the file<br>';
	echo '<img src="' . htmlspecialchars($_GET['file']) . '">';
}
?>

<form action="" method="post" enctype="multipart/form-data">
<label for="image">Image:</label>
<input type="file" name="imagefield" id="image">
<input type="submit" name="Upload">
</form>
