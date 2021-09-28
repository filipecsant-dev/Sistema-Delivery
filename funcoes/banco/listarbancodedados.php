<?php
define('HOST', 'den1.mysql5.gear.host');
define('USUARIO', 'deliveryteste');
define('SENHA', 'teste#');

$dbh = new PDO('mysql:host='.HOST.';user='.USUARIO.';password='.SENHA.';');
$statement = $dbh->query('SHOW DATABASES');
print_r( $statement->fetchAll() );