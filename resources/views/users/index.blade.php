<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 AJAX CRUD Operations With Popup Modal - Vidvatek</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<div class="container">
    <h1 class="mb-5 mt-4"> CRUD Ajax - Usuarios </h1>
    <a class="btn btn-success mb-4" href="javascript:void(0)" id="createNewUser"> Nuevo Registro</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Username</th>
                <th>Correo</th>
                <th width="280px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal" novalidate method="POST">
                    @csrf
                    <input type="text" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese Nombre" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-2 control-label">Apellido</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Ingrese Apellido" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese Username" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Correo</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese Correo" value="" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Contraseña</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese Contraseña" value="" maxlength="100" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

    <script type="text/javascript">

        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ajax-crud.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            $('#createNewUser').click(function () {
                $('#saveBtn').val("create-user");
                $('#saveBtn').html("Guardar");
                $('#name').val('');
                $('#last_name').val('');
                $('#username').val('');
                $('#email').val('');
                $('#password').val('');
                $('#userForm').trigger("reset");
                $('#modelHeading').html('Nuevo Usuario');
                $('#modal').modal('show');
            });

            $('body').on('click', '.editUser', function () {
                var user_id = $(this).data('id');
                $.get("{{ route('ajax-crud.index') }}" +'/' + user_id +'/edit', function (data) {
                    $('#modelHeading').html("Editar Usuario");
                    $('#modal').modal('show');
                    $('#saveBtn').val("edit-user");
                    $('#saveBtn').html("Editar");
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#last_name').val(data.last_name);
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                });
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "{{ route('ajax-crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#userForm').trigger("reset");
                        $('#modal').modal('hide');
                        table.draw();

                    },
                    error: function (data) {
                        console.log('Error', data);
                        $('#saveBtn').html('Reintentar');
                    }

                });
            });

        });

    </script>

</html>
