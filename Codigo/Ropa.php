<?php
require_once 'Producto.php';

// Clase Ropa
class Ropa extends Producto {
    private $talla;
    private $material;
    private $color;

    public function __construct(?String $id, $nombre, $precio, $stock, $marca, $talla, $material, $color) {
        parent::__construct($id, $nombre, $precio, $stock, $marca);
        $this->talla = $talla;
        $this->material = $material;
        $this->color = $color;
    }

    // Getters
    public function getTalla() {
        return $this->talla;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getColor() {
        return $this->color;
    }

    // Setters
    public function setTalla($talla) {
        $this->talla = $talla;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setColor($color) {
        $this->color = $color;
    }


    

    // Método toString
    public function __toString() {
        return parent::__toString() . ", Ropa{talla='" . $this->talla . "', material='" . $this->material .
               "', color='" . $this->color . "'}";
    }
}
?>
