<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración del encabezado de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>

    <!-- Script JavaScript para recargar la tabla -->
    <script>
        function recargarTabla() {
            // Recarga la página actual
            location.reload();
        }
    </script>

    <!-- Enlace a la hoja de estilos externa "Modificar.css" -->
    <link rel="stylesheet" type="text/css" href="Modificar.css">
</head>
<body>
    <!-- Título de la página -->
    <h2>Modificar Producto</h2>

    <?php
        // Incluir las clases necesarias
        require_once 'Tienda.php';
        require_once 'Ropa.php';
        require_once 'Equipamiento.php'; 
        require_once 'Principal.php';

        // Iniciar la sesión (si no está iniciada)
        if(!isset($_SESSION)){session_start();}

        // Configuración para mostrar errores
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Obtener todos los productos de la tienda
        $productos = $_SESSION['tienda']->getProductos();
    ?>

    <!-- Formulario para modificar productos -->
    <form action="" method="post">
        <br>
        <!-- Campo de entrada para el ID del producto a modificar -->
        <label for="id">ID del Producto a Modificar:</label>
        <input type="text" name="id"><br>

        <!-- Campos para ingresar los nuevos valores del producto -->
        <label for="nombre">Nuevo Nombre del Producto:</label>
        <input type="text" name="nombre"><br>

        <label for="precio">Nuevo Precio:</label>
        <input type="number" name="precio" step="0.01"><br>

        <label for="stock">Nuevo Stock:</label>
        <input type="number" name="stock"><br>

        <label for="marca">Nueva Marca:</label>
        <input type="text" name="marca"><br>

        <!-- Campos específicos para Ropa -->
        <label for="talla">Nueva Talla (solo para Ropa):</label>
        <input type="text" name="talla"><br>

        <label for="material">Nuevo Material (solo para Ropa):</label>
        <input type="text" name="material"><br>

        <label for="color">Nuevo Color (solo para Ropa):</label>
        <input type="text" name="color"><br>

        <!-- Campos específicos para Equipamiento Deportivo -->
        <label for="tipo_equipo">Nuevo Tipo (solo para Equipamiento Deportivo):</label>
        <input type="text" name="tipo_equipo"><br>

        <label for="deportes">Nuevo Deporte (solo para Equipamiento Deportivo):</label>
        <input type="text" name="deportes"><br>

        <label for="detalles">Nuevos Detalles (solo para Equipamiento Deportivo):</label>
        <input type="text" name="detalles"><br>

        <label for="garantia">Nueva Garantía (solo para Equipamiento Deportivo):</label>
        <input type="text" name="garantia"><br>

        <!-- Botón para enviar el formulario y recargar la tabla -->
        <input type="submit" value="Modificar Producto" onclick="recargarTabla()">
        <br><br>
        
    </form>
    <br>

    <!-- Tabla que muestra los productos actuales de la tienda -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Marca</th>
            <th>Tipo</th>
            <th>Talla/Deporte</th>
            <th>Material/Detalles</th>
            <th>Color/Garantía</th>
        </tr>

        <!-- Ciclo foreach para iterar sobre los productos y mostrarlos en la tabla -->
        <?php foreach ($productos as $producto) : ?>
            <tr>
                <td><?= $producto->getId() ?></td>
                <td><?= $producto->getNombre() ?></td>
                <td><?= number_format($producto->getPrecio(), 2) ?> €</td>
                <td><?= $producto->getStock() ?></td>
                <td><?= $producto->getMarca() ?></td>

                <!-- Verificación del tipo de producto para mostrar la información adecuada -->
                <?php if ($producto instanceof EquipamientoDeportivo) : ?>
                    <td><?= $producto->getTipo() ?></td>
                    <td><?= $producto instanceof Ropa ? '' : $producto->getDeportes() ?></td>
                    <td><?= $producto instanceof Ropa ? '' : $producto->getDetalles() ?></td>
                    <td><?= $producto instanceof Ropa ? '' : $producto->getGarantia() ?></td>
                <?php elseif ($producto instanceof Ropa) : ?>
                    <td>ROPA</td>
                    <td><?= $producto->getTalla() ?></td>
                    <td><?= $producto->getMaterial() ?></td>
                    <td><?= $producto->getColor() ?></td>
                <?php else : ?>
                    <td>Desconocido</td>
                    <td>Desconocido</td>
                    <td>Desconocido</td>
                    <td>Desconocido</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
        // Procesar el formulario cuando se envíe
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger los valores del formulario
            $id = $_POST["id"];
            $nombre = strtoupper($_POST["nombre"]);
            $precio = $_POST["precio"];
            $stock = $_POST["stock"];
            $marca = strtoupper($_POST["marca"]);

            // Campos específicos para Ropa
            $talla = strtoupper($_POST["talla"]);
            $material = strtoupper($_POST["material"]);
            $color = strtoupper($_POST["color"]);

            // Campos específicos para Equipamiento Deportivo
            $tipoEquipo = strtoupper($_POST["tipo_equipo"]);
            $deportes = strtoupper($_POST["deportes"]);
            $detalles = strtoupper($_POST["detalles"]);
            $garantia = strtoupper($_POST["garantia"]);

            // Verificar si todos los campos necesarios están vacíos
            if (empty($id) || (empty($nombre) && empty($precio) && empty($stock) && empty($marca) && empty($talla) && empty($material) && empty($color) && empty($tipoEquipo) && empty($deportes) && empty($detalles) && empty($garantia))) {
                // Mostrar mensaje de error si faltan campos
                echo "<p>Por favor, completa al menos el ID y un campo adicional para modificar el producto.</p>";
            } else {
                $productoModificado = null;

                // Verificar los campos específicos para Ropa
                if (!empty($talla) && !empty($material) && !empty($color)) {
                    $productoModificado = new Ropa(null, $nombre, $precio, $stock, $marca, $talla, $material, $color);
                } 
                // Verificar los campos específicos para Equipamiento Deportivo
                elseif (!empty($tipoEquipo) && !empty($deportes) && !empty($detalles) && !empty($garantia)) {
                    $productoModificado = new EquipamientoDeportivo(null, $nombre, $precio, $stock, $marca, $tipoEquipo, $deportes, $detalles, $garantia);
                }

                // Buscar el producto en la tienda por ID
                $producto = $_SESSION['tienda']->buscarProductoPorId($id);

                // Verificar si se encontró el producto y si se proporcionó un producto modificado
                if ($producto != null && $productoModificado != null) {
                    // Eliminar el producto original
                    $_SESSION['tienda']->eliminarProductoPorId($id);

                    // Agregar el producto modificado
                    $_SESSION['tienda']->addProductos($productoModificado, false);

                    // Mostrar mensaje de éxito
                    echo "<p>Producto modificado con éxito.</p>";
                } else {
                    // Mostrar mensaje si el producto no se encuentra o los datos ingresados no son válidos
                    echo "<p>No se encontró un producto con el ID proporcionado o los datos ingresados no son válidos.</p>";
                }
            }
        }
    ?>

</body>
</html>
