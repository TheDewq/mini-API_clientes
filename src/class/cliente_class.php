<?php

    require("src/db/config.php");
    require("src/db/db_connect.php");


    class cliente{
        
        public static function obtener_todo(){ // obtener_todo():json
            $server = db_connect();

            $sql = "SELECT * FROM cliente;";
            $rpt = $server->prepare($sql);
            try{
                $rpt->execute();
            }catch(PDOException $e){
                header("HTTP/1.1 404 not found");
                exit;
            }
            $resultados = $rpt->fetchAll(PDO::FETCH_ASSOC);
            $json_resultados = json_encode($resultados);
            
            return $json_resultados;
                    
        }

        public static function obtener_por_id($id){
            $server = db_connect();

            $sql = "SELECT * FROM cliente WHERE id = :id;";
            $rpt = $server->prepare($sql);
            $rpt->bindParam(":id", $id);
            try{
                $rpt->execute();
            }catch(PDOException $e){
                header("HTTP/1.1 404 not found");
                exit;
            }
            
            $resultados = $rpt->fetchAll(PDO::FETCH_ASSOC);
            $json_resultados = json_encode($resultados);
            
            return $json_resultados;
        }

        public static function eliminar_por_id(){
            $server = db_connect();

            $sql = "DELETE FROM cliente WHERE id = :id;";
            $rpt = $server->prepare($sql);
            $rpt->bindParam(":id", $id);
            try{
                $rpt->execute();
                header("HTTP/1.1 200 usuario eliminado");
            }catch(PDOException $e){
                header("HTTP/1.1 404 not found");
            }
        }
        public static function agregar($nombre, $apellido, $birth, $sexo){
            $server = db_connect();

            $sql = "INSERT INTO cliente (nombre, apellido, fecha_nacimiento, sexo) VALUES (:nombre, :apellido, :birth, :sexo);";
            $rpt = $server->prepare($sql);
            $rpt->bindParam(':nombre', $nombre, PDO::PARAM_STR, 64);
            $rpt->bindParam(':apellido', $apellido, PDO::PARAM_STR, 64);
            $rpt->bindParam(':birth', $birth);
            $rpt->bindParam(':sexo', $sexo, PDO::PARAM_STR, 1);
            try{
                $rpt->execute();
                header("HTTP/1.1 201 usuario creado");
            }catch(PDOException $e){
                header("HTTP/1.1 500 usaurio no creado");
            }
        }

        public static function modificar($id = null, $nombre  = null, $apellido  = null, $birth  = null, $sexo  = null){
            $server = db_connect();
            if($id == null || !is_numeric($id)){
                header("HTTP/1.1 400 DATOS NO VALIDOS");
                exit;
            }
            $sql = "UPDATE cliente SET ";
            if($nombre == null && $apellido == null && $birth == null && $sexo == null){
                header("HTTP/1.1 400 SOLICITUD SIN DATOS");
                exit;
            }

            if($nombre != null){
                $sql .= "nombre = :nombre";
                if($apellido != null || $birth != null || $sexo != null){
                    $sql .= ",";
                }
            }
            if ($apellido != null) {
                $sql .= "apellido = :apellido";
                if($birth != null || $sexo != null){
                    $sql .= ",";
                }
            }
            
            if ($birth != null) {
                $sql .= "fecha_nacimiento = :birth";
                if($sexo != null){
                    $sql .= ",";
                }
            }
            
            if ($sexo != null) {
                $sql .= "sexo = :sexo";
            }
            $sql .= " WHERE id = :id";
            
            $rpt = $server->prepare($sql);

            if ($nombre != null) {
                $rpt->bindParam(':nombre', $nombre);
            }
            
            if ($apellido != null) {
                $rpt->bindParam(':apellido', $apellido);
            }
            
            if ($birth != null) {
                $rpt->bindParam(':birth', $birth);
            }
            
            if ($sexo != null) {
                $rpt->bindParam(':sexo', $sexo);
            }
            $rpt->bindParam(":id", $id);
            // si alguno falta que no me pare el programa, ya las verificaciones se hicieron previamente
            try{
                $rpt->execute();
                header("HTTP/1.1 200 usuario modificado");
            }catch(PDOException $e){
                echo $e;
                header("HTTP/1.1 500 usaurio no modificado");
            }





        }
    }
    