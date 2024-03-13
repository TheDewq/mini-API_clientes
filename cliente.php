<?php
require("src/class/cliente_class.php");

switch ($_SERVER["REQUEST_METHOD"]) {
    case 'GET':
        if(empty($_GET)){
            //echo "si";
            echo (cliente::obtener_todo());
        }
        if(isset($_GET["id"])){
            echo (cliente::obtener_por_id($_GET['id']));
        }
        break;
    
    case 'POST':
        if(!(isset($_GET['nombre']) && isset($_GET['apellido']) && isset($_GET['fecha_nacimiento']) && isset($_GET['sexo']) )){
            header("HTTP/1.1 400 DATOS FALTANTES");
            exit;
        }
        
        cliente::agregar($_GET['nombre'], $_GET['apellido'], $_GET['fecha_nacimiento'], $_GET['sexo']);

        break;
        
    case 'PUT':
        if(!(isset($_GET['id']) || isset($_GET['nombre']) || isset($_GET['apellido']) || isset($_GET['fecha_nacimiento']) || isset($_GET['sexo']) )){
            header("HTTP/1.1 400 sin datos");
            exit;
        }
            error_reporting(0);
            cliente::modificar($_GET['id'],$_GET['nombre'], $_GET['apellido'], $_GET['fecha_nacimiento'], $_GET['sexo']);
        

        break;

    case 'DELETE':
                # code...
        break;
    default:
        header("HTTP/1.1 403 ILLEGAL REQUEST");
    
}