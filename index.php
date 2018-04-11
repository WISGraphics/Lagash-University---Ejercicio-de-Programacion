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

	<div class="container mt-4">
		<h1 class="display-4 text-center">Parquimetro inteligente</h1><hr>

		<!-- LISTA -->
		<div class="row my-5">
			<div class="col-md-4">
				<form action="modelo_vehiculo.php" method="POST">
					<div class="form-group">
						<label for="nombre">Nombre:</label>
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Introduzca el nombre" required>
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Introduzca el email" requiered>
					</div>
					<div class="form-group">
						<label for="nombre">Patente:</label>
						<input type="text" class="form-control" id="patente" name="patente" placeholder="Introduzca la patente" requiered>
					</div>
					<input type="hidden" name="crear" value="crear">
					<input type="submit" class="btn btn-success btn-block" value="Guardar">
				</form>
			</div>
			<div class="col-md-8">
				<table class="table table-hover">
			  		<thead>
					    <tr>
						    <th scope="col">Nombre</th>
						    <th scope="col">Email</th>
						    <th scope="col">Patente</th>
						    <th scope="col">Estacionado</th>
						    <th scope="col">Estado</th>
					    </tr>
				  	</thead>
					<tbody>
				    	<?php 
			    			$sql = "SELECT * FROM vehiculo";
							$resultado = $conn->query($sql);
				    		while ($vehiculo = $resultado->fetch_assoc()): 
		    			?>
					    <tr>				
				      		<th><?php echo $vehiculo['nombre']; ?></th>
				      		<th><?php echo $vehiculo['email']; ?></th>
				      		<th scope="row"><?php echo $vehiculo['patente']; ?></th>
				      		<th class="text-center">
				      			<?php
				      				$patente = $vehiculo['patente'];
				      				settype( $patente, 'string' );

				      				if($vehiculo['estacionado'] == 1){
				      					echo "<i class='fas fa-check'></i>";
				      					//$ControladorParquimetro->AutoDetectado($patente);
				      				} else{
				      					echo "<i class='fas fa-times'></i>";
				      					//$ControladorParquimetro->EstacionamientoFinalizado();
				      					//ServicioExterno::EnviarEmail($asunto, $cuerpo, $destinatario, $cabeceras);
				      				}
			      				?>				      				
			      			</th>
				      		<th>
			      				<a href="modelo_vehiculo.php?id=<?php echo $vehiculo['id']; ?>" class="btn btn-info" id="cambiar">
			      					Cambiar
			      				</a>
				      		</th>
					    </tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- FIN LISTA -->

		<!-- CONSULTAS -->
		<div class="row my-5">
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h5 class="text-center">Consultar Patente</h5>
					</div>
					<div class="card-body text-center">
						<p>
							<?php
								$ControladorParquimetro->Patente($conn);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h5 class="text-center">Consultar minutos estacionado</h5>
					</div>
					<div class="card-body text-center">
						<table class="table table-hover">
					  		<thead>
							    <tr>
								    <th scope="col">Patente</th>
								    <th scope="col">Tiempo</th>
								    <th scope="col">A pagar</th>
							    </tr>
						    </thead>
						    <tbody>
						    	<?php
						    		$sql = "SELECT * FROM vehiculo WHERE `estacionado` = 1";
									$resultado = $conn->query($sql);
						    		while ( $vehiculo = $resultado->fetch_assoc() ) : ?>
						    		<tr>
										<th id="patente_estacionado"><?php echo $vehiculo['patente']; ?></th>
										<th scope="row">
											<?php
												$ControladorParquimetro->MinutosEstacionado($conn);
											?>
										</th>
										<th scope="row">
											<?php
												$ControladorParquimetro->CentavosPorHora($conn);
											?>
										</th>
									</tr>
						    	<?php endwhile; ?>						    	
						    </tbody>
					    </table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<h5 class="text-center">Consultar/establecer precio</h5>
					</div>
					<div class="card-body">
						<?php
							$sql = "SELECT * FROM `precios`";
							$resultado = $conn->query($sql);
							$precios = $resultado->fetch_assoc();

							$minuto = $precios['minuto'];
							$hora = $precios['hora'];
							$dia = $precios['dia'];
							echo "Precio por minuto: <b>$" . $minuto . "</b><br>";
							echo "Precio por hora: <b>$" . $hora . "</b><br>";
							echo "Precio por dia: <b>$" . $dia . "</b>";
						?>
						<hr>
						<a href="actualizar_precios.php" class="btn btn-success btn-block">Actualizar precio/s</a>					
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