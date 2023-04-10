@extends('menu')
@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="/css/buttons.dataTables.min.css">

@endsection

@section('content')
    <div class="card" style="margin-top: 20px;">
        <div class="card-body">
            <h1 class="card-title">Tabla de precios históricos de la UF</h1>
            <a class="btn btn-primary" href="javascript:void(0)" id="NuevaEntrada" style="float: right;"> Nueva Entrada</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-hover data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Unidad de Medida</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                            <th>Tiempo</th>
                            <th>Origen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade" id="ajaxModel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="IndicadoresForm" name="IndicadoresForm" class="form-horizontal">
                            <input type="hidden" name="Indicadores_id" id="Indicadores_id">
                            <div class="form-group">
                                <label for="NombreIndicador" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="NombreIndicador" name="NombreIndicador"
                                        placeholder="Ingresar Valor" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="CodigoIndicador" class="col-sm-2 control-label">Código</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="CodigoIndicador" name="CodigoIndicador"
                                        placeholder="Ingresar Valor" value="" maxlength="50" required="true">
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="UnidadMedidaIndicador" class="col-m-2 control-label">Unidad de
                                    Medida</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="UnidadMedidaIndicador"
                                        name="UnidadMedidaIndicador" placeholder="Ingresar Valor" value=""
                                        maxlength="50" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="ValorIndicador" class="col-sm-2 control-label">Valor</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="ValorIndicador" name="ValorIndicador"
                                        placeholder="Ingresar Valor" value="" maxlength="50" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="FechaIndicador" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" id="FechaIndicador" name="FechaIndicador"
                                        value="" maxlength="50" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="TiempoIndicador" class="col-sm-2 control-label">Tiempo</label>
                                <div class="col-sm-12">
                                    <input type="time" class="form-control" id="TiempoIndicador" name="TiempoIndicador"
                                        placeholder="Ingresar Valor" value="" maxlength="50">
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="OrigenIndicador" class="col-sm-2 control-label">Origen</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="OrigenIndicador"
                                        name="OrigenIndicador" placeholder="Ingresar Valor" value=""
                                        maxlength="50" required>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Agregar
                                    Indicador
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src='/js/jquery-3.6.0.min.js'></script>
    <script src='/js/jquery.dataTables.min.js'></script>
    <script src='/js/dataTables.buttons.min.js'></script>
    <script src='/js/jszip.min.js'></script>
    <script src='/js/pdfmake.min.js'></script>
    <script src='/js/vfs_fonts.js'></script>
    <script src='/js/buttons.html5.min.js'></script>
    <script src='/js/buttons.print.min.js'></script>
    <script src='/js/buttons.print.min.js'></script>



    <script type="text/javascript">
        $(function() {


        //Pass Header Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        //Generación de Tabla
            var table = $('.data-table').DataTable({
                dom: 'Brtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                processing: true,
                serverSide: true,
                scrollY: '50vh',
                scrollCollapse: true,
                ajax: "{{ route('crud.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nombreIndicador',
                        name: 'NombreIndicador'
                    },
                    {
                        data: 'codigoIndicador',
                        name: 'CodigoIndicador'
                    },
                    {
                        data: 'unidadMedidaIndicador',
                        name: 'UnidadMedidaIndicador'
                    },
                    {
                        data: 'valorIndicador',
                        name: 'ValorIndicador'
                    },
                    {
                        data: 'fechaIndicador',
                        name: 'FechaIndicador'
                    },
                    {
                        data: 'tiempoIndicador',
                        name: 'TiempoIndicador'
                    },
                    {
                        data: 'origenIndicador',
                        name: 'OrigenIndicador'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


        //Boton "agregar nueva entrada"

            $('#NuevaEntrada').click(function() {
                $('#saveBtn').val("Agregar Indicador");
                $('#Indicadores_id').val('');
                $('#IndicadoresForm').trigger("reset");
                $('#modelHeading').html("Agregar Nueva Entrada");
                $('#ajaxModel').modal('show');
            });


        //Botón editar registro
            $('body').on('click', '.editIndicadores', function() {
                var Indicadores_id = $(this).data('id');
                $.get("{{ route('crud.index') }}" + '/' + Indicadores_id + '/edit', function(data) {
                    $('#modelHeading').html("Editar Indicadores");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#Indicadores_id').val(data.id);
                    $('#NombreIndicador').val(data.nombreIndicador);
                    $('#CodigoIndicador').val(data.codigoIndicador);
                    $('#UnidadMedidaIndicador').val(data.unidadMedidaIndicador);
                    $('#ValorIndicador').val(data.valorIndicador);
                    $('#FechaIndicador').val(data.fechaIndicador);
                    $('#TiempoIndicador').val(data.tiempoIndicador);
                    $('#OrigenIndicador').val(data.origenIndicador);
                })
            });


        //Función de agregar Indicadores
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var form = $('#IndicadoresForm');
                var formData = form.serialize();
                var requiredInputs = form.find('input[required]');
                var hasEmptyFields = false;

                requiredInputs.each(function() {
                    if ($(this).val() === '') {
                        hasEmptyFields = true;
                        return false;
                    }
                });

                if (hasEmptyFields) {
                    alert('Por favor completa todos los campos.');
                    return;
                }

                $(this).html('Enviando..');

                $.ajax({
                    data: formData,
                    url: "{{ route('crud.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        form.trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Agregar Indicador');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Agregar Indicador');
                    }
                });
            });


        //Botón borrado de datos
            $('body').on('click', '.deleteIndicadores', function() {

                var Indicadores_id = $(this).data("id");
                if (confirm("¿ Estas seguro que deseas borrarlo ?")) {

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('crud.store') }}" + '/' + Indicadores_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {

                }
            });

        });
    </script>
@stop
