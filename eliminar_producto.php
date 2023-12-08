<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM productos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // El registro se ha eliminado. Redirigir inmediatamente.
    } else {
        // Opcionalmente, manejar el error de alguna forma.
    }

    // Cerrar la sentencia y la conexión antes de redirigir.
    $stmt->close();
    $conn->close();

    // Redirigir inmediatamente al index.php.
    header("Location: index.php");
    exit();
}
?>
