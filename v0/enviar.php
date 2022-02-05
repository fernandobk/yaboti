<pre><?php
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
$html_volver = '<h1><a href="javascript:history.back()">↩ Volver o enviar otro</a></h1>';
$ip = $_SERVER['REMOTE_ADDR'];
$date = date('H').'h'. date('i').'m'.date('s').'s';
$a_cant = count($_FILES['archivo']['name']);


// Mostrar info y comprobar tamaño
echo '- IP: '.$ip.PHP_EOL;
echo '- Archivos recibidos: '.count($_FILES['archivo']['name']).PHP_EOL;
echo '<details>- POST: '.var_export($_POST, true).PHP_EOL.'- FILES: '.var_export($_FILES, true).PHP_EOL.'</details>'.PHP_EOL;


// Verificar si hay tareas, sino dar aviso de error
if( !$a_cant AND !$_POST['texto'] ){ exit('<h1>✗ ERROR: No se recibió ningún archivo.</h1>'.$html_volver); }


// Establecer carpeta de ubicación
$carpeta = 'recibidos/';
if( !is_dir("./$carpeta") ) {
		echo "- mkdir(./$carpeta): " . var_export( mkdir("./$carpeta")?:exit, true ) . PHP_EOL;
}
$carpeta .= $_POST['asignatura'].'/';
echo "- is_dir($carpeta): " . var_export(is_dir("./$carpeta"), true) . PHP_EOL;
if( !is_dir("$carpeta") ) {
		echo "- mkdir($carpeta): " . var_export( mkdir("$carpeta")?:exit, true ) . PHP_EOL;
}
$carpeta .= date('m-d/');
echo "- is_dir($carpeta): " . var_export(is_dir("./$carpeta"), true) . PHP_EOL;
if( !is_dir("$carpeta") ) {
		echo "- mkdir($carpeta): " . var_export( mkdir("$carpeta")?:exit, true ) . PHP_EOL;
}
$carpeta .= $_POST['nombre'].'/';
echo "- is_dir($carpeta): " . var_export(is_dir("./$carpeta"), true) . PHP_EOL;
if( !is_dir("$carpeta") ) {
		echo "- mkdir($carpeta): " . var_export( mkdir("$carpeta")?:exit, true ) . PHP_EOL;
}
$carpeta .= $date.'/';
echo "- is_dir($carpeta): " . var_export(is_dir("./$carpeta"), true) . PHP_EOL;
if( !is_dir("$carpeta") ) {
		echo "- mkdir($carpeta): " . var_export( mkdir("$carpeta")?:exit, true ) . PHP_EOL;
}

// Creamos el archivo de texto "texto.txt" si existe
if( $_POST['texto'] ){
		echo "- file_put_contents(): ".var_export( file_put_contents($carpeta.'texto.txt', $_POST['texto'])?:exit,true ).PHP_EOL;
		echo "- chmod(777): ".var_export( chmod($carpeta.'texto.txt', 0777)?:exit,true ).PHP_EOL;
}


// Copiamos los archivos enviados a la carpeta, si existen
for( $i = 0; $i < $a_cant; $i++ ){
		echo "<details><summary>Archivo $i</summary>";

		$a = new stdClass; // archivo actual
		$a->name = $_FILES['archivo']['name'][$i];
		$a->tmp_name = $_FILES['archivo']['tmp_name'][$i];
		$a->size = $_FILES['archivo']['size'][$i];

		// Comprobar si el archivo no es nulo
		echo '- is_uploaded_file(): '.var_export( is_uploaded_file( $a->tmp_name )?:exit, true ) . PHP_EOL;
		echo '- Tamaño de archivo: '.$a->size.' Bytes, '.($a->size / 1024).' KB'.PHP_EOL;
		if( !$a->size ){
				exit('<h1>✗ ERROR: El archivo enviado está vacío.</h1>'.$html_volver);
		}

		// Movemos el archivo a la carpeta
		echo "- move_uploaded_file(): ".var_export( move_uploaded_file($a->tmp_name, $carpeta.$a->name)?:exit, true ).PHP_EOL;
		echo "- chmod(777): ".var_export(chmod($carpeta.$a->name, 0777)?:exit,true).PHP_EOL;

		echo '</details>';
}

// Guardamos en el registro el archivo subido (próximamente)


// Si llegamos hasta acá es porque está todo bien.
if ( $_POST['texto'] ) { $a_cant = $a_cant + 1; }
echo PHP_EOL."<hr /><title>• $a_cant Archivos enviados ✓</title><h1>• $a_cant Archivos enviados ✓ </h1>".$html_volver;
