<?php
require_once 'Producto.php';
// Clase EquipamientoDeportivo
class EquipamientoDeportivo extends Producto {
    private $tipo;
    private $deportes;
    private $detalles;
    private $garantia;

    public function __construct(?String $id,$nombre, $precio, $stock, $marca, $tipo, $deportes, $detalles, $garantia) {
        parent::__construct($id,$nombre, $precio, $stock, $marca);
        $this->tipo = $tipo;
        $this->deportes = $deportes;
        $this->detalles = $detalles;
        $this->garantia = $garantia;
    }

    // Getters
    public function getTipo() {
        return $this->tipo;
    }

    public function getDeportes() {
        return $this->deportes;
    }

    public function getDetalles() {
        return $this->detalles;
    }

    public function getGarantia() {
        return $this->garantia;
    }

    // Setters
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setDeportes($deportes) {
        $this->deportes = $deportes;
    }

    public function setDetalles($detalles) {
        $this->detalles = $detalles;
    }

    public function setGarantia($garantia) {
        $this->garantia = $garantia;
    }
    
    // Método toString
    public function __toString() {
        return parent::__toString() . ", EquipamientoDeportivo{tipo='" . $this->tipo . "', deportes='" . $this->deportes .
               "', detalles='" . $this->detalles . "', garantia='" . $this->garantia . "'}";
    }
}

?>