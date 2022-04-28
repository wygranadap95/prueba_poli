@extends('layouts.app')

@section('content')
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.5/pdfobject.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.5/pdfobject.js" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap5.min.css" rel="stylesheet">
</head>
<style>
    #formulario {
        width: 50% !important;
        height: 50% !important;
        margin-left: 20%;
        padding: 16px;
        border-radius: 10px;
        margin: auto;
        margin-top: 2px;
        background-color: #ccc;
    }

    #btn_guard {
        margin-top: 2%;
    }

    #titulo {
        margin-left: 45%;
    }
</style>

<body>
    <h3 id="titulo">Registro libros</h1>

        <div id="formulario">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombre">
            </div>
            <div class="form-group">
                <label>Autor</label>
                <select id="id_autor" name="id_autor" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach($arregloA as $arreA)
                    <option value="{{$arreA['id']}}"> {{$arreA['nombre']}} - {{$arreA['apellido']}} </option>
                    @endforeach
                </select>
                <input type="hidden" class="form-control" id="id">
            </div>

            <button id="btn_guard" class="btn btn-primary">Procesar</button>
        </div>

        <div>
            <table class="table table-hover" id="example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Autor</th>
                        <th>Nombre Libro</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($arregloT as $arreT)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$arreT['nombre']}} {{$arreT['apellido']}}</td>
                        <td>{{$arreT['nomb_libro']}}</td>
                        <td>
                            <button type="button" class="btn btn-info btn_edit" id="btn_edit" value="{{$arreT['id']}}"> Editar </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn_del" id="btn_del" value="{{$arreT['id']}}"> Eliminar </button>
                        </td>
                    </tr> @endforeach
                </tbody>
            </table>
        </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#example').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        $('#btn_guard').click(function() {

            var id = $("#id").val();
            if (id == null || id == '') {
                id = 0;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/libros') }}",
                data: {
                    'nombre': $('#nombre').val(),
                    'id_autor': $('#id_autor').val(),
                    'id': id
                },
                success: function(rsp) {
                    console.log(rsp)
                    if (rsp == 'ok') {
                        Swal.fire({
                            title: 'Buen trabajo!',
                            text: 'Se ingresaron los datos correctamente',
                            type: 'success',
                            confirmButtonText: 'Cerrar'
                        });
                        setTimeout("location.reload(true);", 150);
                    } else if (rsp == 'upd') {
                        Swal.fire({
                            title: 'Buen trabajo!',
                            text: 'Se Actualizaron los datos correctamente',
                            type: 'success',
                            confirmButtonText: 'Cerrar'
                        });
                        setTimeout("location.reload(true);", 150);
                    }

                },
                error: function() {
                    alert('error 404 ');
                }
            });
        });
        $('.btn_del').click(function() {
            var codigo = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/libros/delete') }}",
                data: {
                    'id': codigo
                },
                success: function(rsp) {
                    console.log(rsp)
                    if (rsp == 'ok') {
                        Swal.fire({
                            title: 'Proceso!',
                            text: 'Se Eliminaron los datos correctamente',
                            type: 'danger',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                    setTimeout("location.reload(true);", 200);
                },
                error: function() {
                    alert('error 404 ');
                }
            });
        });
        $('.btn_edit').click(function() {
            var codigo = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ url('/libros/update') }}",
                data: {
                    'id': codigo
                },
                success: function(rsp) {
                    $.each(rsp, function() {
                        var nombre = $(this).attr('nombre');
                        var id_autor = $(this).attr('id_autor');
                        var id = $(this).attr('id');
                        $('#nombre').val(nombre);
                        $('#id_autor').val(id_autor);

                        $('#id').val(id);
                    });
                    $("#identificacion").attr('disabled', true);
                    $("#btn_guard").text('Actualizar');
                },
                error: function() {
                    alert('error 404 ');
                }
            });
        });
    });
</script>

</html>
@endsection