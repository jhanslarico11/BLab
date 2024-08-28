$(document).ready(function() {
    // Cargar usuarios al cargar la página
    loadUsers();

    function loadUsers() {
        $.ajax({
            url: "php/fetch_users.php",
            method: "GET",
            success: function(data) {
                $("#userTable tbody").html(data);
            }
        });
    }

    // Mostrar modal para crear/editar usuario
    $('#userModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var userId = button.data('id');
        var modal = $(this);

        if (userId) {
            // Editar usuario
            $.ajax({
                url: "php/fetch_user.php",
                method: "GET",
                data: { id: userId },
                dataType: "json",
                success: function(data) {
                    modal.find('.modal-title').text('Editar Usuario');
                    modal.find('#userId').val(data.id);
                    modal.find('#nombre_rs').val(data.nombre_rs);
                    modal.find('#dni').val(data.dni);
                    modal.find('#ruc').val(data.ruc);
                    modal.find('#correo').val(data.correo);
                    modal.find('#celular').val(data.celular);
                    modal.find('#rol').val(data.rol);
                    modal.find('#user').val(data.user);
                    modal.find('#existing_cv').val(data.cv);
                    modal.find('#cv').val(null); // No resetear el campo de CV
                },
                error: function() {
                    alert('Error al cargar los datos del usuario.');
                }
            });
        } else {
            // Crear nuevo usuario
            modal.find('.modal-title').text('Crear Usuario');
            modal.find('form')[0].reset();
            modal.find('#userId').val('');
            modal.find('#existing_cv').val('');
            modal.find('#cv').val(null);
        }
    });

    // Guardar o actualizar usuario
    $("#userForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "php/add_edit_user.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#userModal').modal('hide');
                loadUsers();
            },
            error: function() {
                alert('Error al guardar los datos del usuario.');
            }
        });
    });

    // Eliminar usuario
    $(document).on('click', '.delete-btn', function() {
        if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
            var userId = $(this).data('id');
            $.ajax({
                url: "php/delete_user.php",
                method: "POST",
                data: { id: userId },
                success: function(response) {
                    loadUsers();
                },
                error: function() {
                    alert('Error al eliminar el usuario.');
                }
            });
        }
    });
});
