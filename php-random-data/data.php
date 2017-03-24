<?php
// Will generate 50k random "names" and "addresses"
// Change database name in dbname=...
// and table name in INSERT INTO data

$p = new PDO('mysql:host=localhost;dbname=random;charset=utf8', 'bootcamp', '');
$p->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$s = time();
$stmt = $p->prepare('INSERT INTO data (name, address) VALUES (?, ?)');
for ($i = 0; $i < 50000; $i++) {
	$stmt->execute([
		base64_encode(random_bytes(50)),  // random name, requires PHP7
		base64_encode(random_bytes(100)),  // random address, requires PHP7
	]);
}

echo 'Time required: ' . (time() - $s) . 's';
