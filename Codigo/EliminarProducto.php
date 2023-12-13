<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" type="text/css" href="Eliminar.css">
</head>
<body>

<h2>Eliminar Producto</h2>

<?php
require_once 'Tienda.php';
require_once 'Ropa.php';
require_once 'Equipamiento.php';
require_once 'producto.php';
require_once 'Principal.php';

if (!isset($_SESSION)) {
    session_start();
}

// Inicializar la tienda si no está definida en la sesión
$tienda = isset($_SESSION['tienda']) ? $_SESSION['tienda'] : new Tienda(1, "Mi Tienda", "Mi Dirección");
$_SESSION['tienda'] = $tienda;
?>

<form action="" method="post" onsubmit="return confirmarEliminacion()">
    <br>
    <label for="id">ID del Producto:</label>
    <input type="text" name="id"><br>

    <input type="submit" value="Eliminar Producto">
</form>

<script>
    function confirmarEliminacion() {
        return confirm("¿Estás seguro de que quieres eliminar este producto?");
    }
</script>

<?php
// Verificar si se ha enviado el formulario y si hay un ID proporcionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Recoger el valor del formulario
    $id = $_POST["id"];

    // Verificar si el ID no está vacío antes de realizar la eliminación
    if (!empty($id)) {
        // Obtener el producto correspondiente al ID
        $productoAEliminar = $tienda->getProductoPorId($id);

        // Verificar si se encontró el producto antes de intentar eliminarlo
        if ($productoAEliminar) {
            // Eliminar el producto en la tienda
            $tienda->rmProductos($productoAEliminar);

            // Redirigir a la misma página para actualizar la tabla de productos
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            // Mostrar un mensaje si no se encuentra el producto
            echo "<p>No se encontró un producto con el ID proporcionado.</p>";
        }
    } else {
        // Mostrar un mensaje si el ID está vacío
        echo "<p>Por favor, ingrese el ID del producto a eliminar.</p>";
    }
}

// Mostrar la tabla con el nombre y la ID de los productos
echo "<h3>Productos actuales:</h3>";
$productos = $tienda->obtenerProductos();
if (!empty($productos)) {
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>";
    foreach ($productos as $producto) {
        echo "<tr>
                <td>{$producto->getId()}</td>
                <td>{$producto->getNombre()}</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay productos disponibles.</p>";
}
?>
</body>
</html>
