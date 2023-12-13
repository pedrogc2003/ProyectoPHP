<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración del encabezado de la página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por Deporte</title>

    <!-- Enlace a la hoja de estilos externa "BuscarDeporte.css" -->
    <link rel="stylesheet" type="text/css" href="BuscarDeporte.css">
</head>
<body>
    <!-- Título de la página -->
    <h2>Buscar por Deporte</h2>

    <?php
        // Incluir las clases necesarias
        require_once 'Tienda.php';
        require_once 'Equipamiento.php';
        require_once 'Principal.php';

        // Iniciar la sesión (si no está iniciada)
        if (!isset($_SESSION)) {
            session_start();
        }
    ?>

    <!-- Formulario para buscar productos por deporte -->
    <form action="" method="post">
        <br>
        <!-- Campo de entrada para el deporte -->
        <label for="deporte">Buscar por Deporte:</label>
        <input type="text" name="deporte">
        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Buscar">
    </form>

    <?php
    // Procesamiento del formulario cuando se envía (método POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Recoger el valor del formulario y convertir a mayúsculas
        $deporte = strtoupper($_POST["deporte"]);

        // Verificar si el deporte no está vacío antes de realizar la búsqueda
        if (!empty($deporte)) {
            // Utilizar la función buscarProductoPorDeporte de la clase Tienda
            $productosEncontrados = $_SESSION['tienda']->buscarProductoPorDeporte($deporte);

            // Mostrar los productos encontrados en una tabla
            if (!empty($productosEncontrados)) {
                echo "<h3>Productos relacionados con el deporte '$deporte' encontrados:</h3>";
                echo "<table border='1'>";
                echo "<tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Marca</th>
                    </tr>";
                foreach ($productosEncontrados as $producto) {
                    echo "<tr>
                            <td>{$producto->getNombre()}</td>
                            <td>" . number_format($producto->getPrecio(), 2) . " €</td>
                            <td>{$producto->getStock()}</td>
                            <td>{$producto->getMarca()}</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                // Mostrar un mensaje si no se encontraron productos
                echo "<p>No se encontraron productos relacionados con el deporte especificado.</p>";
            }
        } else {
            // Mostrar un mensaje si el deporte está vacío
            echo "<p>Por favor, ingrese un deporte para realizar la búsqueda.</p>";
        }
    }
    ?>
</body>
</html>
