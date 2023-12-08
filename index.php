<?php
include('conexion.php'); // Incluye tu script de conexión a la base de datos

// Verifica si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_producto'])) {
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $caducidad = $_POST['caducidad'];
    $cantidad = $_POST['cantidad']; // Asegúrate de que este campo exista en tu formulario

    // Preparar la sentencia SQL para insertar
    $stmt = $conn->prepare("INSERT INTO productos (producto, precio, caducidad, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", $producto, $precio, $caducidad, $cantidad);
    $stmt->execute();
    $stmt->close();
    
    // Redireccionar a la misma página para evitar reenvíos del formulario
    header("Location: index.php");
    exit();
}

// Consulta para obtener todos los productos
$resultado = $conn->query("SELECT * FROM productos");

// Verifica si la consulta fue exitosa
if ($resultado === false) {
    echo "Error en la consulta: " . $conn->error;
    exit(); // Si hay un error, termina el script
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Moderna</title>
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
            <a class="navbar-brand" href="#">
                <img src="R.webp" alt="Tienda" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Productos para agregar a la tienda de Karina</h2>
        <form method="POST" action="index.php">
            <div class="mb-3">
                <label for="producto" class="form-label">Producto:</label>
                <input type="text" class="form-control" id="producto" name="producto" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="caducidad" class="form-label">Caducidad:</label>
                <input type="date" class="form-control" id="caducidad" name="caducidad" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
            <button type="submit" class="btn btn-primary" name="agregar_producto">Agregar Producto</button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Caducidad</th>
                    <th>Cantidad</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['producto']); ?></td>
                    <td><?php echo htmlspecialchars($row['precio']); ?></td>
                    <td><?php echo htmlspecialchars($row['caducidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td>
                        <a class="btn btn-outline-primary" href="formulario_modificar.php?id=<?php echo $row['id']; ?>">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="eliminar_producto.php">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4 fixed-bottom">
        <p>Karina Huerta Mota &copy; 2023</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>