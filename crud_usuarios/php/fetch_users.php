<?php
include 'config.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['nombre_rs']}</td>
            <td>{$row['dni']}</td>
            <td>{$row['ruc']}</td>
            <td>{$row['correo']}</td>
            <td>{$row['celular']}</td>
            <td>{$row['rol']}</td>
            <td>{$row['user']}</td>
            <td>
                <button class='btn btn-warning btn-sm edit-btn' data-id='{$row['id']}'>Editar</button>
                <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Eliminar</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No hay usuarios registrados.</td></tr>";
}

$conn->close();
?>
