$(document).ready(function() {
    function loadUsers() {
        $.ajax({
            url: 'php/fetch_users.php',
            method: 'GET',
            success: function(data) {
                $('#user-table-body').html(data);
            }
        });
    }

    loadUsers();

    $('#add-user-btn').click(function() {
        $('#userModalLabel').text('Crear Usuario');
        $('#user-form')[0].reset();
        $('#user-id').val('');
        $('#userModal').modal('show');
    });

    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: 'php/fetch_user.php',
            method: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(user) {
                $('#userModalLabel').text('Editar Usuario');
                $('#user-id').val(user.id);
                $('#nombre_rs').val(user.nombre_rs);
                $('#dni').val(user.dni);
                $('#ruc').val(user.ruc);
                $('#correo').val(user.correo);
                $('#celular').val(user.celular);
                $('#rol').val(user.rol);
                $('#user').val(user.user);
                $('#userModal').modal('show');
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'php/delete_user.php',
                    method: 'POST',
                    data: { id: id },
                    success: function(response) {
                        const result = JSON.parse(response);
                        if (result.success) {
                            Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success');
                            loadUsers();
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                        }
                    }
                });
            }
        });
    });

    $('#user-form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'php/add_edit_user.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    $('#userModal').modal('hide');
                    Swal.fire('Éxito', 'Usuario guardado exitosamente.', 'success');
                    loadUsers();
                } else {
                    Swal.fire('Error', 'No se pudo guardar el usuario.', 'error');
                }
            }
        });
    });
});
