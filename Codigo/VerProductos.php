<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración del encabezado de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Productos</title>

    <!-- Enlace a la hoja de estilos externa "Ver.css" -->
    <link rel="stylesheet" type="text/css" href="Ver.css">
</head>
<body>
    <!-- Título de la página -->
    <h2>Ver Todos los Productos</h2>

    <?php
        // Incluir las clases necesarias
        require_once 'Tienda.php';
        require_once 'Ropa.php';
        require_once 'Equipamiento.php'; 
        require_once 'Principal.php';

        // Iniciar la sesión (si no está iniciada)
        if (!isset($_SESSION)) {
            session_start();
        }

        // Configuración para mostrar errores
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Obtener todos los productos de la tienda
        $productos = $_SESSION['tienda']->getProductos();
    ?>

    <!-- Tabla que muestra los productos -->
    <br>
    <table border="1">
        <tr>
            <!-- Encabezados de la tabla -->
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
                <!-- Columnas con información del producto -->
                <td><?= $producto->getId() ?></td>
                <td><?= $producto->getNombre() ?></td>
                <td><?= number_format($producto->getPrecio(), 2) ?> €</td>
                <td><?= $producto->getStock() ?></td>
                <td><?= $producto->getMarca() ?></td>

                <!-- Verificación del tipo de producto para mostrar la información adecuada -->
                <?php if ($producto instanceof Ropa) : ?>
                    <!-- Mostrar detalles específicos de Ropa -->
                    <td>ROPA</td>
                    <td><?= $producto->getTalla() ?></td>
                    <td><?= $producto->getMaterial() ?></td>
                    <td><?= $producto->getColor() ?></td>
                <?php elseif ($producto instanceof EquipamientoDeportivo) : ?>
                    <!-- Mostrar detalles específicos de Equipamiento Deportivo -->
                    <td><?= $producto->getTipo() ?></td>
                    <td><?= $producto->getDeportes() ?></td>
                    <td><?= $producto->getDetalles() ?></td>
                    <td><?= $producto->getGarantia() ?></td>
                <?php else : ?>
                    <!-- Manejar otros tipos de productos aquí -->
                    <td>Otro Tipo</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
