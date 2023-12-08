<?php
include('conexion.php');

// Asegúrate de que el ID del producto a modificar ha sido pasado a este script
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID de producto no encontrado.');

// Consulta para obtener la información del producto
$query = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_producto'])) {
    // Recoge los valores del formulario
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $caducidad = $_POST['caducidad'];
    $cantidad = $_POST['cantidad'];

    // Preparar la sentencia SQL para actualizar
    $stmt = $conn->prepare("UPDATE productos SET producto=?, precio=?, caducidad=?, cantidad=? WHERE id=?");
    $stmt->bind_param("sdsii", $producto, $precio, $caducidad, $cantidad, $id);
    $stmt->execute();

    // Redireccionar al index.php
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

// Si aún no se ha enviado el formulario, muestra la información actual del producto en el formulario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0e4d7; /* Color pastel para el fondo */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #343a40; /* Asegurándose de que la barra de navegación sea oscura */
        }
        .navbar .navbar-brand img {
            height: 50px;
        }
        .navbar .nav-link {
            color: #fff;
        }
        .navbar .nav-link:hover {
            color: #f8f9fa;
        }
        .table-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="R.webp" alt="Tienda" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Ubicación</a>
                    <a class="nav-link" href="#">Inicio</a>
                    <a class="nav-link" href="#">Consultas</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Modificar Producto</h2>
        <form method="POST" action="formulario_modificar.php?id=<?php echo $id; ?>">
            <div class="mb-3">
                <label for="producto" class="form-label">Producto:</label>
                <input type="text" class="form-control" id="producto" name="producto" value="<?php echo htmlspecialchars($row['producto']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($row['precio']); ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="caducidad" class="form-label">Caducidad:</label>
                <input type="date" class="form-control" id="caducidad" name="caducidad" value="<?php echo htmlspecialchars($row['caducidad']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo htmlspecialchars($row['cantidad']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar_producto">Guardar Cambios</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4 fixed-bottom">
        Karina Huerta Mota &copy; 2023
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
