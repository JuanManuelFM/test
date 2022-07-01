<?php
include 'BaseDatos.php';

/*
CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
*/

class Pasajero{
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;
    private $Objviaje;
    private $mensajeFuncion;


    public function __construct()
    {
        $this->nombre="";
        $this->apellido="";
        $this->documento="";
        $this->telefono="";
        $this->Objviaje='';
    }

    public function cargar($nombre, $apellido, $documento, $telefono, $Objviaje){
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setDocumento($documento);
        $this->setTelefono($telefono);
        $this->setObjviaje($Objviaje);
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setDocumento($documento){
        $this->documento = $documento;
    }
    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }
    public function setObjviaje($Objviaje){
        $this->Objviaje = $Objviaje;
    }
    public function setMensajeFuncion($mensajeFuncion){
        $this->mensajeFuncion = $mensajeFuncion;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getDocumento(){
        return $this->documento;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getObjviaje(){
        return $this->Objviaje;
    }
    public function getMensajeFuncion(){
        return $this->mensajeFuncion;
    }

    /*
    pdocumento 
    pnombre 
    papellido 
    ptelefono 
    idviaje 

    getNombre
    getApellido
    getDocumento
    getTelefono
    getObjViaje
    getMensajeFuncion

    */
    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consulta= "INSERT INTO pasajero (rdocumento, pnombre, papellido, ptelefono, idviaje) VALUES ('".$this->getDocumento()."', '".$this->getNombre()."',
        '".$this->getApellido()."',
        '".$this->getTelefono()."',
        '".$this->getObjviaje()->getIdviaje()."')"; 
		if($base->Iniciar()){
			    if($base->Ejecutar($consulta)){
			        $resp=  true;
			    }	
                else{
				    $this->setMensajeFuncion($base->getError());	
			    }
		    } 
            else{
				$this->setMensajeFuncion($base->getError());
		    }
		return $resp;
	}
    
    /*
    rdocumento 
    pnombre 
    papellido 
    ptelefono 
    idviaje 

    getNombre
    getApellido
    getDocumento
    getTelefono
    getObjviaje
    getMensajeFuncion

    */

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consulta="UPDATE Pasajero
         SET 
         pnombre= '".$this->getNombre()."',
         papellido= '".$this->getApellido()."',
         ptelefono= '".$this->getTelefono()."',
         rdocumento= '".$this->getDocumento()."',
         idviaje = ".$this->getObjviaje()->getIdviaje()."
         WHERE rdocumento= ". $this->getDocumento();
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
			    $resp=  true;
			}
            else{
				$this->setMensajeFuncion($base->getError());	
			}
		}
        else{
			$this->setMensajeFuncion($base->getError());	
		}
		return $resp;
	}

    /*
    rdocumento 
    pnombre 
    papellido 
    ptelefono 
    idviaje 

    getNombre
    getApellido
    getDocumento
    getTelefono
    getObjviaje
    getMensajeFuncion

    */

    public function Buscar($documento){
		$base=new BaseDatos();
		$consulta="SELECT * FROM pasajero WHERE rdocumento= " .$documento;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consulta)){
				if($pasajero=$base->Registro()){					
				    $this->setDocumento($documento);
					$this->setNombre($pasajero['pnombre']);
                    $this->setApellido($pasajero['papellido']);
					$this->setTelefono($pasajero['ptelefono']);
                    $objViaje = new Viaje();
                    $objViaje->Buscar($pasajero['idviaje']);
                    $this->setObjviaje($objViaje);
					$resp= true;
				}				
		 	}
            else{
		 		$this->setMensajeFuncion($base->getError());
			}
		}	
        else{
		 	$this->setMensajeFuncion($base->getError());
		}		
	return $resp;
	}	

    /*
    rdocumento 
    pnombre 
    papellido 
    ptelefono 
    idviaje 

    getNombre
    getApellido
    getDocumento
    getTelefono
    getObjviaje
    getMensajeFuncion

    */

    public function listar($condicion=""){
        $arregloPasajeros= null;
		$base=new BaseDatos();
		$consultaPasajero="SELECT * FROM pasajero ";
		if ($condicion != ""){
		    $consultaPasajero=$consultaPasajero.' WHERE '.$condicion;
		}
		$consultaPasajero.=" ORDER BY pnombre ";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$arregloPasajeros= array();
				while($pasajero=$base->Registro()){
					$objPasajero= new Pasajero();
					$objPasajero->buscar($pasajero['rdocumento']);
					array_push($arregloPasajeros,$objPasajero);
				}
		 	}
            else{
		 		$this->setMensajeFuncion($base->getError());	
			}
		}
        else{
		 	$this->setMensajeFuncion($base->getError());
		}	
		return $arregloPasajeros;
	}	

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consulta="DELETE FROM pasajero WHERE rdocumento= " . $this->getDocumento();
				if($base->Ejecutar($consulta)){
				    $resp=  true;
				}
                else{
					$this->setMensajeFuncion($base->getError());	
				}
		}
        else{
			$this->setMensajeFuncion($base->getError());	
		}
		return $resp; 
	}

    /*
    rdocumento 
    pnombre 
    papellido 
    ptelefono 
    idviaje 

    getNombre
    getApellido
    getDocumento
    getTelefono
    getObjviaje
    getMensajeFuncion

    */

    public function __toString(){
	    return(  
            "Nombre del pasajero: ".$this->getNombre().
            "\n Apellido del pasajero: ".$this->getApellido().
            "\n Documento del pasajero: ".$this->getDocumento().
            "\n Codigo del viaje: ".$this->getObjviaje()->getIdviaje().
            "\n El telefono del pasajero es: ".$this->getTelefono());
	}
}