<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadUsers() {
                $.get('php/fetch_users.php', function(data) {
                    $('#userTable tbody').html(data);
                });
            }

            loadUsers();

            // Crear o Editar usuario
            $('#userForm').submit(function(e) {
                e.preventDefault();
                $.post('php/add_edit_user.php', $(this).serialize(), function() {
                    $('#userModal').modal('hide');
                    loadUsers();
                });
            });

            // Editar usuario
            $('#userTable').on('click', '.edit-btn', function() {
                var id = $(this).data('id');
                $.get('php/fetch_user.php', { id: id }, function(data) {
                    var user = JSON.parse(data);
                    $('#userId').val(user.id);
                    $('#nombre_rs').val(user.nombre_rs);
                    $('#dni').val(user.dni);
                    $('#ruc').val(user.ruc);
                    $('#correo').val(user.correo);
                    $('#celular').val(user.celular);
                    $('#rol').val(user.rol);
                    $('#user').val(user.user);
                    $('#userModalLabel').text('Editar Usuario');
                    $('#userModal').modal('show');
                });
            });

            // Eliminar usuario
            $('#userTable').on('click', '.delete-btn', function() {
                if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                    var id = $(this).data('id');
                    $.post('php/delete_user.php', { id: id }, function() {
                        loadUsers();
                    });
                }
            });
        });
    </script>
</head>
<body>
    <div class="container mt-4">
        <h1>Gestión de Usuarios</h1>
        <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#userModal">Crear Usuario</button>
        <table class="table table-striped" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre/Razón Social</th>
                    <th>DNI</th>
                    <th>RUC</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Rol</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargan aquí con AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal para Crear/Editar Usuario -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId" name="id">
                        <div class="form-group">
                            <label for="nombre_rs">Nombre/Razón Social</label>
                            <input type="text" class="form-control" id="nombre_rs" name="nombre_rs" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" required>
                        </div>
                        <div class="form-group">
                            <label for="ruc">RUC</label>
                            <input type="text" class="form-control" id="ruc" name="ruc" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" required>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <input type="text" class="form-control" id="rol" name="rol" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Usuario</label>
                            <input type="text" class="form-control" id="user" name="user" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
