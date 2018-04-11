<?php include_once 'modelo.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	<title>Parquimetros - Lagash University</title>
</head>
<body>

	<div class="container">
		<h1 class="display-4 text-center">Actualizar</h1><hr>

		<!-- CONSULTAS -->
		<div class="row my-5 justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h5 class="text-center">Establecer precios</h5>
					</div>
					<div class="card-body">
						<?php

						$sql = "SELECT * FROM `precios`";
						$resultado = $conn->query($sql);
						$precios = $resultado->fetch_assoc();

						$minuto = $precios['minuto'];
						$hora = $precios['hora'];
						$dia = $precios['dia'];

						?>
						<form action="modelo_vehiculo.php" method="POST">
							<div class="form-group">
								<label for="minuto">Minuto:</label>
								<input type="number" step="0.01" name="minuto" id="minuto" class="form-control" value="<?php echo $minuto ?>">
							</div>
							<div class="form-group">
								<label for="minuto">hora:</label>
								<input type="number" name="hora" id="hora" class="form-control" value="<?php echo $hora ?>">
							</div>
							<div class="form-group">
								<label for="minuto">día:</label>
								<input type="number" name="dia" id="dia" class="form-control" value="<?php echo $dia ?>">
							</div>
							<input type="hidden" name="actualizar_precio" value="actualizar_precios">
							<input type="submit" class="btn btn-success btn-block">
						</form>			
					</div>
				</div>
			</div>
		</div>
		<!-- FIN CONSULTAS -->

	</div> <!-- CONTAINER -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>
