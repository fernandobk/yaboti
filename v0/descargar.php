<?php
if( isset($_GET['archivo']) ){
		if( file_exists('descargas/'.$_GET['archivo']) ){
				header('Cache-Control: public');
				header('Content-Description: File Transfer');
				header('Content-disposition: attachment; filename='.$_GET['archivo']);
				header('Content-type: application/octet-stream');
				header('Content-Transfer-Encoding: binary');
				
				readfile('descargas/'.$_GET['archivo']);
				
				exit;
		} else {
				exit('Nombre del archivo a descargar incorrecto.');
		}
}

