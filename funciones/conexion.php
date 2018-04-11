<?php 

	$host="localhost";
	$usuario="root";
	$contraseña="";
	$db_nombre="parquimetro";

	$conn = new mysqli($host, $usuario, $contraseña, $db_nombre);

	if ($conn->connect_errno) {
	    echo "Fallo al conectar a MySQL: " . $conn->connect_error;
	}

?>