<?php

function conectarBD() {
    
    try {
        $connection_bd = new PDO('mysql:host=localhost; dbname=ejemplo_clase_san_jose', 'root', '');
        $connection_bd -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection_bd -> exec('SET CHARACTER SET utf8');
        return $connection_bd;
    } catch (Exception $e) {
        die('Error: '.$e->GetMessage());
    }
}

function upload_image($archivo) {
    
    // tomar la url para la bd
    
    $validacion_ok = 1;
    $directorio_imagenes = 'imagenes/';
    $url_final = $directorio_imagenes.basename($archivo['name']);

    $tipo_imagen_archivo = strtolower(pathinfo($url_final, PATHINFO_EXTENSION));

    // Validación, si el archivo existe

    if(file_exists($url_final)) {
        echo 'La imagen ya existe!';
        $validacion_ok = 0;
    }

    // Validación tamaño imagen
    if ($archivo['size'] > 5000000) {
        echo 'El archivo es muy grande!';
        $validacion_ok = 0;
    }

    // Formatos permitidos
    if ($tipo_imagen_archivo != 'jpg' && $tipo_imagen_archivo != 'jpeg' && $tipo_imagen_archivo != 'png') {
        echo 'El formato del archivo no es permitido';
        $validacion_ok = 0;
    }

    if ($validacion_ok == 0 ) {
        echo 'La imagen no se puede subir';
        return null;
    } else {
        if (move_uploaded_file($archivo['tmp_name'], $url_final)) {
            echo 'La imagen fue subida correctamente!';
            return $url_final;
        } else {
            echo 'Hubo un error al subir la imagen';
            return null;
        }
    }
}
?>