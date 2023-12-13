<?php

// Importar la clase Producto para poder usarla en la Tienda
require_once 'Producto.php';

class Tienda
{
    // Atributos privados de la clase Tienda
    private $id;
    private $nombre;
    private $direccion;
    private $productos; // Lista de productos en la tienda

    // Constructor de la clase Tienda
    public function __construct($id, $nombre, $direccion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->productos = array(); // Inicializar la lista de productos como un array vacío
    }

    // Getters para acceder a los atributos privados
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    // Getter para obtener la lista de productos
    public function getProductos() {
        return $this->productos;
    }

    // Setters para modificar los atributos privados
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    // Método para agregar un producto a la lista de productos
    public function agregarProducto($producto) {
        $this->productos[] = $producto;
    }

    // Método para eliminar un producto por objeto Producto
    public function rmProductos(Producto $producto): bool {
        // Verificar si el objeto $producto existe y es una instancia de la clase Producto
        if (isset($producto) && ($producto instanceof Producto)) {
            // Verificar si el producto está en la tienda
            if ($this->contieneProducto($producto)) {
                // Eliminar el producto de la tienda
                unset($this->productos[$producto->getId()]);
                return true;
            }
        }
        return false;
    }

    // Método para buscar productos por talla (específico para productos de tipo Ropa)
    public function buscarProductoPorTalla($talla) {
        $productosEncontrados = [];

        foreach ($this->productos as $producto) {
            // Verificar si el producto es de tipo Ropa y tiene la talla especificada
            if ($producto instanceof Ropa && $producto->getTalla() == $talla) {
                $productosEncontrados[] = $producto;
            }
        }

        return $productosEncontrados;
    }

    // Método para buscar EquipamientoDeportivo por deporte
    public function buscarProductoPorDeporte($deporte){
        $productosEncontrados = [];

        foreach ($this->productos as $producto) {
            if ($producto instanceof EquipamientoDeportivo && in_array($deporte, explode(',', $producto->getDeportes()))) {
                $productosEncontrados[] = $producto;
            }
        }

        return $productosEncontrados;
    }

    // Método para obtener todos los productos en la tienda
    public function obtenerProductos(): array {
        $result = [];
        foreach ($this->productos as $producto) {
            $result[] = $producto;
        }
        return $result;
    }

    // Método para buscar productos por marca
    public function buscarProductoPorMarca($marca){
        $productosEncontrados = [];

        foreach ($this->productos as $producto) {
            if ($producto->getMarca() == $marca) {
                $productosEncontrados[] = $producto;
            }
        }

        return $productosEncontrados;
    }

    // Método para verificar si un producto ya está en la tienda
    public function contieneProducto(Producto $producto): bool {
        foreach ($this->productos as $key => $value) {
            // Comparar productos por su ID o algún otro criterio único
            if ($value->getId() === $producto->getId()) {
                return true; // El producto ya está en la tienda
            }
        }
        return false; // El producto no está en la tienda
    }

    // Método para agregar o modificar productos en la tienda
    public function addProductos(Producto $producto, bool $nuevo): bool {
        // Verificar si el nuevo objeto $producto existe y es una instancia de la clase Producto
        if ($producto !== null && $producto instanceof Producto) {
            // Verificar si el producto ya está en la tienda y no se debe modificar
            if ($this->contieneProducto($producto) && !$nuevo) {
                // No se puede añadir un producto duplicado
                return false;
            } elseif (!$this->contieneProducto($producto) && $nuevo) {
                // No se puede modificar un producto que no existe
                return false;
            } else {
                // Añadir o modificar el producto en la tienda
                $this->productos[$producto->getId()] = $producto;
                return true;
            }
        } else {
            // El objeto $producto no es válido
            return false;
        }
    }

    // Método para obtener un producto por su ID
    public function getProductoPorId($id) {
        foreach ($this->productos as $producto) {
            if ($producto->getId() == $id) {
                return $producto;
            }
        }
        return null; // Si no se encuentra el producto con el ID dado
    }

    // Método para modificar un producto en la tienda
    public function modificarProducto($id, $nuevosValores): bool {
        // Buscar el producto en la tienda por ID
        $producto = $this->getProductoPorId($id);

        // Verificar si se encontró el producto
        if ($producto != null) {
            // Crear un nuevo producto con los nuevos valores
            $productoModificado = $this->crearProductoDesdeArray($nuevosValores);

            // Modificar el producto con los nuevos valores
            $this->addProductos($productoModificado, false);

            return true;
        }

        return false;
    }

    // Método privado para crear un objeto Producto desde un array de valores
    private function crearProductoDesdeArray($valores): Producto {
        $id = $valores['id'] ?? null;
        $nombre = $valores['nombre'] ?? null;
        $precio = $valores['precio'] ?? null;
        $stock = $valores['stock'] ?? null;
        $marca = $valores['marca'] ?? null;
        $talla = $valores['talla'] ?? null;
        $material = $valores['material'] ?? null;
        $color = $valores['color'] ?? null;
        $tipoEquipo = $valores['tipo_equipo'] ?? null;
        $deportes = $valores['deportes'] ?? null;
        $detalles = $valores['detalles'] ?? null;
        $garantia = $valores['garantia'] ?? null;

        // Ajusta esto según tus clases de productos
        if (!empty($talla) && !empty($material) && !empty($color)) {
            return new Ropa($id, $nombre, $precio, $stock, $marca, $talla, $material, $color);
        } elseif (!empty($tipoEquipo) && !empty($deportes) && !empty($detalles) && !empty($garantia)) {
            return new EquipamientoDeportivo($id, $nombre, $precio, $stock, $marca, $tipoEquipo, $deportes, $detalles, $garantia);
        } else {
            // Si no se especifica un tipo específico, crea un Producto genérico
            return new Producto($id, $nombre, $precio, $stock, $marca);
        }
    }

    // Método para buscar un producto por su ID
    public function buscarProductoPorId($id) {
        foreach ($this->productos as $producto) {
            if ($producto->getId() == $id) {
                return $producto;
            }
        }
        return null; // Si no se encuentra el producto con el ID dado
    }

    // Método para eliminar un producto por su ID
    public function eliminarProductoPorId($id) {
        // Verificar si el ID existe en la tienda
        if (isset($this->productos[$id])) {
            // Eliminar el producto por ID
            unset($this->productos[$id]);
        }
    }
}

?>
