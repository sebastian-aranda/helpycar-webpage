<?php 

function getRating($id_local){
	
	$suma = 0.0;
	$cantidad = 0.0;
	$promedio = 0.0;
	
	$calificaciones = getCalificaciones($id_local);
	foreach ($calificaciones as $calificacion){
		$suma += $calificacion->nota;
		$cantidad++;
	}

	if ($cantidad != 0)
		$promedio = $suma/$cantidad;
	else
		$promedio = 0;

	return round($promedio);
}

?>