<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Índice</title>
    <link rel="stylesheet" type="text/css" href="Principal.css">

</head>
<body>
    <?php
    
    
            // Incluye la clase Tienda y las clases de los productos según sea necesario
            require_once 'Tienda.php';
            require_once 'Ropa.php';
            require_once 'Equipamiento.php';
        
            session_start(); // Inicia la sesión si no está iniciada
            if (!isset($_SESSION['tienda'])) {
                // Si la variable de sesión 'tienda' no está definida, crea una nueva instancia y asígnala a la sesión
                $tienda = new Tienda(1, "Panda Shop", "Calle - San Pedro, nº 104");
                $_SESSION['tienda'] = $tienda;
            }
            
    
    // Manejar el formulario solo si se ha enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["tipoProducto"])) {
            $tipoProducto = $_POST["tipoProducto"];

            // Realiza acciones según el tipo de producto seleccionado
            switch ($tipoProducto) {
                case 'verProductos':
                    header("Location: VerProductos.php");
                    exit;  // Asegura que el script se detenga después de la redirección
                case 'anadir':
                    header("Location: AnadirProducto.php");
                    exit;
                case 'modificar':
                    header("Location: ModificarProducto.php");
                    exit;
                case 'eliminar':
                    header("Location: EliminarProducto.php");
                    exit;
                case 'buscarDeporte':
                    header("Location: BuscarDeporte.php");
                    exit;
                case 'buscarMarca':
                    header("Location: BuscarMarca.php");
                    exit;
                case 'buscarTalla':
                    header("Location: BuscarTalla.php");
                    exit;
                default:
                    // Acción por defecto si no coincide con ninguna opción
                    echo "Acción no válida";
            }
        } else {
            
        }
    }
    ?>

    <form action="Principal.php" method="post">
        <button type="submit" name="tipoProducto" value="verProductos">Ver Productos</button>
        <button type="submit" name="tipoProducto" value="anadir">Añadir Productos</button>
        <button type="submit" name="tipoProducto" value="modificar">Modificar Productos</button>
        <button type="submit" name="tipoProducto" value="eliminar">Eliminar Productos</button>
        <button type="submit" name="tipoProducto" value="buscarDeporte">Buscar por Deporte</button>
        <button type="submit" name="tipoProducto" value="buscarMarca">Buscar por Marca</button>
        <button type="submit" name="tipoProducto" value="buscarTalla">Buscar por Talla</button>
    </form>
</body>
</html>
