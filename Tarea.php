<?php

class Tarea
{
    private $nombre;
    private $descripcion;
    private $prioridad;
    private $fechaLim;


    public function __construct($nombre, $descripcion, $prioridad, $fechaLim)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->prioridad = $prioridad;
        $this->fechaLim = $fechaLim;
    }

	public function getNombre() {
		return $this->nombre;
	}
	
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	
	public function getDescripcion() {
		return $this->descripcion;
	}
	

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}
	

	public function getPrioridad() {
		return $this->prioridad;
	}
	
	
	public function setPrioridad($prioridad){
		$this->prioridad = $prioridad;
	}
	
	
	public function getFechaLim() {
		return $this->fechaLim;
	}
	
	public function setFechaLim($fechaLim){
		$this->fechaLim = $fechaLim;
	}
}
