<?php
require_once 'ControlID.php';

class Producto implements ControlID {

    private const PRODUCTO = "PRDUCT";

    private $id;
    private $nombre;
    private $precio;
    private $stock;
    private $marca;

    public function __construct(?String $id ,$nombre, $precio, $stock, $marca) {
        if($id !== null){
            $this->id = $id;
        }else{
            $this->id = $this->generarID();
        }  // Se inicia en 0 y se incrementará en agregarProducto
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->marca = $marca;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    private function generarID(): String{
        $aleatorio = random_int(0,1000);
        $id = uniqid(self::PRODUCTO. "-" .$aleatorio, true);
        return $id;
    }

    public function controlarID() {
        // Puedes agregar lógica aquí si es necesario
        // Por ejemplo, validar que el ID cumpla con ciertos criterios
        // o realizar acciones adicionales relacionadas con el ID
    }

    public function __toString() {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Precio: {$this->precio}, Stock: {$this->stock}, Marca: {$this->marca}";
    }
}

?>
