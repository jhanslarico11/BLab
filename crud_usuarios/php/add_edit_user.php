<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre_rs = $_POST['nombre_rs'];
    $dni = $_POST['dni'];
    $ruc = $_POST['ruc'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $rol = $_POST['rol'];
    $user = $_POST['user'];
    $existing_cv = $_POST['existing_cv'];

    $cv = $_FILES['cv']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($cv);

    if ($cv) {
        if (move_uploaded_file($_FILES['cv']['tmp_name'], $target_file)) {
            $cv_path = "uploads/" . basename($cv);
        } else {
            $cv_path = $existing_cv;
        }
    } else {
        $cv_path = $existing_cv;
    }

    if (empty($id)) {
        $sql = "INSERT INTO usuarios (nombre_rs, dni, ruc, correo, celular, rol, user, cv)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nombre_rs, $dni, $ruc, $correo, $celular, $rol, $user, $cv_path);
    } else {
        $sql = "UPDATE usuarios SET nombre_rs=?, dni=?, ruc=?, correo=?, celular=?, rol=?, user=?, cv=?
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $nombre_rs, $dni, $ruc, $correo, $celular, $rol, $user, $cv_path, $id);
    }

    if ($stmt->execute()) {
        echo "Usuario guardado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
