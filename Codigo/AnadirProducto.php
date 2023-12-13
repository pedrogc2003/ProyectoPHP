<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración del encabezado de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>

    <!-- Enlace a la hoja de estilos externa "Anadir.css" -->
    <link rel="stylesheet" type="text/css" href="Anadir.css">
</head>
<body>
    <!-- Título de la página -->
    <h2>Agregar Producto</h2>

    <?php
        // Incluir las clases necesarias
        require_once 'Tienda.php';
        require_once 'Ropa.php';
        require_once 'Equipamiento.php';
        require_once 'Principal.php';

        // Iniciar la sesión (si no está iniciada)
        if(!isset($_SESSION)){session_start();}
    ?>

    <!-- Formulario para agregar productos -->
    <form action="" method="post">
        <br>
        <!-- Campos generales del producto -->
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" name="nombre" required><br>

        <label for="precio">Precio:</label>
        <input type="number" name="precio" step="0.01" min="0.01" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" required><br>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" required><br>

        <!-- Campos específicos para Ropa -->
        <label for="talla">Talla (solo para Ropa):</label>
        <input type="text" name="talla"><br>

        <label for="material">Material (solo para Ropa):</label>
        <input type="text" name="material"><br>

        <label for="color">Color (solo para Ropa):</label>
        <input type="text" name="color"><br>

        <!-- Campos específicos para Equipamiento Deportivo -->
        <label for="tipo_equipo">Tipo (solo para Equipamiento Deportivo):</label>
        <input type="text" name="tipo_equipo"><br>

        <label for="deportes">Deporte (solo para Equipamiento Deportivo):</label>
        <input type="text" name="deportes"><br>

        <label for="detalles">Detalles (solo para Equipamiento Deportivo):</label>
        <input type="text" name="detalles"><br>

        <label for="garantia">Garantía (solo para Equipamiento Deportivo):</label>
        <input type="text" name="garantia"><br>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Agregar Producto">
    </form>

    <?php
    // Procesamiento del formulario cuando se envía (método POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger los valores del formulario y convertir a mayúsculas
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

        // Verificar si todos los campos están vacíos
        if (empty($nombre) && empty($precio) && empty($stock) && empty($marca) && empty($talla) && empty($material) && empty($color) && empty($tipoEquipo) && empty($deportes) && empty($detalles) && empty($garantia)) {
            // Mostrar mensaje de error si no se completó ningún campo
            echo "<p>Por favor, completa al menos un campo antes de agregar un producto.</p>";
        } else {
            // Determinar el tipo de producto basándose en los campos completados
            if (!empty($talla) || !empty($material) || !empty($color)) {
                // Es un producto de tipo Ropa
                $producto = new Ropa(null, $nombre, $precio, $stock, $marca, $talla, $material, $color);
            } elseif (!empty($tipoEquipo) || !empty($deportes) || !empty($detalles) || !empty($garantia)) {
                // Es un producto de tipo Equipamiento Deportivo
                $producto = new EquipamientoDeportivo(null, $nombre, $precio, $stock, $marca, $tipoEquipo, $deportes, $detalles, $garantia);
            } else {
                // Manejar el caso cuando no se ha completado suficiente información
                echo "<p>Por favor, completa al menos un campo antes de agregar un producto.</p>";
                exit; // Salir del script para evitar la ejecución adicional
            }

            // Agregar el producto a la tienda y actualizar la instancia en la sesión
            if($_SESSION['tienda']->addProductos($producto, false)) {
                // Mostrar mensaje de éxito si se agrega el producto correctamente
                echo "<p>Producto agregado con éxito.</p>";
            } else {
                // Mostrar mensaje de error si hay un problema al agregar el producto
                echo "Error al agregar el producto.";
            }
        }
    }
    ?>

</body>
</html>
