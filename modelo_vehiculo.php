<?php

	include_once 'funciones/conexion.php';

	// REGISTAR VEHICULO
	if (isset($_POST['crear']) == 'crear') {

		$nombre = $_POST['nombre'];
		$email = $_POST['email'];
		$patente = $_POST['patente'];

		try {
			$sql = "INSERT INTO vehiculo (nombre, email, patente) VALUES (?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('sss', $nombre, $email, $patente);
			$stmt->execute();
			if ($stmt->affected_rows) {
				$respuesta = array(
					'respuesta' => 'exito'
				);
			} else{
				$respuesta = array(
					'respuesta' => 'error' 
				);
			}
			$stmt->close();
			$conn->close();
		} catch (Exception $e) {
			$respuesta = array(
					'respuesta' => $e->getMessage()
				);
		}
		die(json_encode($respuesta));
	} // FIN REGISTAR VEHICULO
	
	// EDITAR ESTADO DEL ESTACIONADO
	if (isset($_GET['id'])) {

		$id_editado = $_GET['id'];

		try {
			$sql = "UPDATE vehiculo SET estacionado = !estacionado, tiempo = NOW() WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id_editado);
			$stmt->execute();
			if ($stmt->affected_rows) {
				$respuesta = array(
					'respuesta' => 'exito'
				);
			} else{
				$respuesta = array(
					'respuesta' => 'error' 
				);
			}
			$sql_retiro = "SELECT nombre, email FROM vehiculo WHERE id = $id_editado AND estacionado = 0";
			$resultado = $conn->query($sql_retiro);
			$cliente = $resultado->fetch_assoc();
			include_once 'templates/email_template.php';
			$stmt->close();
			$conn->close();
			header('Location: index.php');
		} catch (Exception $e) {
			$respuesta = array(
					'respuesta' => $e->getMessage()
				);
		}
		die(json_encode($respuesta));
	} // FIN EDITAR ESTADO DEL ESTACIONADO

	// ACTUALIZAR PRECIOS
	if (isset($_POST['actualizar_precio']) == 'actualizar_precio') {
		$minuto = $_POST['minuto'];
		$hora = $_POST['hora'];
		$dia = $_POST['dia'];
		try {
			$sql = "UPDATE `precios` SET minuto = ?, hora = ?, dia = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('dii', $minuto, $hora, $dia);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		header('location: index.php');
	}
	// FIN ACTUALIZAR PRECIOS

?>