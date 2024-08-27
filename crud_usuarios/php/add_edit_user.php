<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre_rs = $_POST['nombre_rs'];
    $dni = $_POST['dni'];
    $ruc = $_POST['ruc'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $rol = $_POST['rol'];
    $user = $_POST['user'];

    if ($id) {
        // Actualizar
        $sql = "UPDATE usuarios SET nombre_rs=?, dni=?, ruc=?, correo=?, celular=?, rol=?, user=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nombre_rs, $dni, $ruc, $correo, $celular, $rol, $user, $id);
    } else {
        // Insertar
        $sql = "INSERT INTO usuarios (nombre_rs, dni, ruc, correo, celular, rol, user) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nombre_rs, $dni, $ruc, $correo, $celular, $rol, $user);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
