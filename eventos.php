<?php

header('Access-Control-Allow-Origin: *');//solucion al error de Cors
 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

header('Content-Type: application/json');

$pdo=new PDO("mysql:dbname=turnos;host=127.0.0.1","root","");



$accion= (isset($_GET['accion']))?$_GET['accion']:'leer';

switch($accion){
  case 'agregar':
     
 $sentenciaSQL = $pdo->prepare("INSERT INTO paciente(dni,nom,tel,os,obs,color,textColor,start,end) VALUES(:dni,:nom,:tel,:os,:obs,:color,:textColor,:start,:end)");

 $respuesta=$sentenciaSQL->execute(array(
        
        "dni" =>$_POST['dni'],
        "nom" =>$_POST['nom'],
        
        "tel" =>$_POST['tel'],
        "os" =>$_POST['os'],
        "obs" =>$_POST['obs'],
        "color" =>$_POST['color'],
        "textColor" =>$_POST['textColor'],
        "start" =>$_POST['start'],
        "end" =>$_POST['end']
        
        
        

      ));
               echo json_encode($respuesta);



    break;


    case 'eliminar':

          $respuesta=false;

          if(isset($_POST['id'])){

            $sentenciaSQL= $pdo->prepare("DELETE FROM paciente WHERE ID=:ID");
            $respuesta= $sentenciaSQL->execute(array("ID"=>$_POST['id']));

          }
               echo json_encode($respuesta);



    break;

    case 'modificar':


        $sentenciaSQL = $pdo->prepare("UPDATE paciente SET
        dni=:dni,
        nom=:nom,
        tel=:tel,
        os=:os,
        obs=:obs,
        color=:color,
        textColor=:textColor,
        start=:start,
        end=:end
        WHERE ID=:ID
        
        
        ");


             $respuesta=$sentenciaSQL->execute(array(
            

              "dni" =>$_POST['dni'],
              "nom" =>$_POST['nom'],
              "tel" =>$_POST['tel'],
              "os" =>$_POST['os'],
              "obs" =>$_POST['obs'],
              "color" =>$_POST['color'],
              "textColor" =>$_POST['textColor'],
              "start" =>$_POST['start'],
              "end" =>$_POST['end']
 
             
            ));
            echo json_encode($respuesta);


        break;
    default:
         //Seleccionar los eventos calendario
         $sentenciaSQL= $pdo->prepare("SELECT * FROM paciente");
         $sentenciaSQL->execute();

         $resultado= $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($resultado);

    break;

}




?>