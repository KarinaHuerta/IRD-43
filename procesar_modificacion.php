<?php
include('conexion.php'); // Incluye la conexión a la base de datos

// Comprueba si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_producto'])) {
    // Recoge los valores del formulario
    $id = $_POST['id'];
    $producto = $_POST['producto'];
    $precio = $_POST['precio'];
    $caducidad = $_POST['caducidad'];
    $cantidad = $_POST['cantidad'];

    // Prepara la consulta SQL para actualizar el producto
    $query = "UPDATE productos SET producto=?, precio=?, caducidad=?, cantidad=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdsii", $producto, $precio, $caducidad, $cantidad, $id);
    $stmt->execute();

    // Verifica si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        $conn->close();
        // Redirige al index.php
        header("Location: index.php");
        exit();
    } else {
        // Maneja el caso en que la actualización no afecte a ninguna fila (por ejemplo, cuando los datos no cambian)
        $stmt->close();
        $conn->close();
        // Puedes optar por mostrar un mensaje de error o simplemente redirigir de todos modos
        header("Location: index.php");
        exit();
    }
} else {
    // Si el formulario no se envió correctamente, redirige a index.php
    header("Location: index.php");
    exit();
}
?>
