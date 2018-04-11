<?php

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	set_time_limit(300);
	
	require_once ('funciones/conexion.php');
	require_once ('templates/EmailTemplate.php');

	interface ControladorParquimetro{
		public function Patente($conn);
		public function MinutosEstacionado($conn);
		public function CentavosPorHora($conn);
		public function AutoDetectado($patente) : void;
		public function AvanzarMinuto() : void;
		public function EstacionamientoFinalizado() : void;
	}

	class parquimetro implements ControladorParquimetro{

		private $minutos_estacionado;
		public $total_a_pagar;

		// PROPIEDAD PATENTE
		public function Patente($conn){

			//QUERY PATENTE
			$sql = "SELECT * FROM vehiculo WHERE `estacionado` = 1";
			$resultado = $conn->query($sql);
			//QUERY PATENTE

			//OBTENER PATENTES
			$estacionados = array ();
			while ( $vehiculo = $resultado->fetch_assoc() ) {
				$estacionados [] = $vehiculo['patente'];
			}
			$estacionados_patente = implode("<br>", $estacionados);
			// FIN OBTENER PATENTES

			if ($estacionados_patente) {
				echo "<p>Auto/s actualmente estacionados: <br><b>" . strtoupper($estacionados_patente) . "</b></p>";
			} else{
				echo "No hay autos estacionados.";
				exit(NULL);
			}
		} // FIN PROPIEDAD PATENTE

		//PROPIEDAD MINUTOS-ESTACIONADO 
		public function MinutosEstacionado($conn){
			try {
				$sql = "SELECT patente, tiempo FROM vehiculo WHERE `estacionado` = 1 AND `patente` = 'aa-123-bc'";
				$resultado = $conn->query($sql);
				$respuesta = $resultado->fetch_assoc();

				$inicio = $respuesta['tiempo'];
				$t1 = strtotime($inicio);
				$actual = date("Y-m-d H:i:s");
		        $t2 = strtotime($actual);

		        $dtd = new stdClass();
		        $dtd->interval = $t2 - $t1;
		        $dtd->total_sec = abs($t2-$t1);
		        $dtd->total_min = floor($dtd->total_sec/60);
		        $dtd->total_hour = floor($dtd->total_min/60);
		        $dtd->total_day = floor($dtd->total_hour/24);

		        $dtd->day = $dtd->total_day;
		        $dtd->hour = $dtd->total_hour - ($dtd->total_day*24);
		        $dtd->min = $dtd->total_min - ($dtd->total_hour*60);
		        $dtd->sec = $dtd->total_sec - ($dtd->total_min*60);

		        $minutos = $dtd->total_min;
		        echo $minutos . " minutos";
		        $this->minutos_estacionado = $minutos;
			} catch (Exception $e) {
				exit(0);
			}
			
		} // FIN PROPIEDAD MINUTOS-ESTACIONADO

		//PROPIEDAD CENTAVOS-POR-HORA
		public function CentavosPorHora($conn) {

			$sql = "SELECT * FROM `precios`";
			$resultado = $conn->query($sql);
			$precios = $resultado->fetch_assoc();

			$hora = $precios['hora'];
			$minutos = $this->minutos_estacionado;

			$total = (floor($minutos / 60) + 1) * $hora;
			$this->total_a_pagar = $total;

			echo "$" . $total;

			$centavos = $hora * 100;
			settype( $centavos, 'integer' );

		} // FIN PROPIEDAD CENTAVOS-POR-HORA

		// MÉTODO AUTO DETECTADO
		public function AutoDetectado($patente) : void {
			echo '
				<script type="text/javascript">
					alert("Nuevo auto estacionado. Patente: ' . $patente . '");
				</script>
			';
		} // FIN MÉTODO AUTO DETECTADO

		// MÉTODO AVANZAR MINUTO
		public function AvanzarMinuto() : void {

		 	$time1 = time();
		 	$i= 0;

			do { $time2 = time(); }
		 	while ($time2 - $time1 < 60);
			$i++;

			echo $i . ' Minuto/s han pasado.';
		} // FIN MÉTODO AVANZAR MINUTO

		// MÉTODO ESTACIONAMIENTO FINALIZADO
		public function EstacionamientoFinalizado() : void {
			echo '
				<script type="text/javascript">
					alert("El auto estacionado se retiró.");
				</script>
			';
		} // FIN MÉTODO ESTACIONAMIENTO FINALIZADO
	}
	
	class ServicioExterno {

		// OBTENER EMAIL POR PATENTE
		public static function ObtenerEmailPorPatente($patente_email, $conn){
			$sql = "SELECT email FROM `vehiculo` WHERE patente = 'aa-123-bc'";
			$resultado = $conn->query($sql);
			$respuesta = $resultado->fetch_assoc();

			$email = $respuesta['email'];

			settype( $email, 'string' );
			return $email;
		} // FIN OBTENER EMAIL POR PATENTE

		// ENVIAR EMAIL
		public static function EnviarEmail($asunto, $cuerpo, $destinatario, $cabeceras){
			mail($destinatario, $asunto, $cuerpo, $cabeceras);
		} // FIN ENVIAR EMAIL
	}

	$ControladorParquimetro = new parquimetro();
	$ServicioExterno = new ServicioExterno();

	//SERVICIO EXTERNO
		//echo ServicioExterno::ObtenerEmailPorPatente($patente_email, $conn);
		//ServicioExterno::EnviarEmail($asunto, $cuerpo, $destinatario, $cabeceras);

?>

