<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-industry"></i>
            Log de Actividades
        </h3>
        <div class="card-tools">
            <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body">
        <table id="table-log" class="table table-sm">
            <thead class="thead-light">
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acción</th>
                <th>Archivo</th>
                <th>Usuario</th>
            </thead>
            <tbody>
                @foreach ($log as $l)
                    <tr data-id="{{ $l->id }}">
                        <td>{{ date('d-m-Y', strtotime($l->created_at)) }}</td>
                        <td>{{ date('H:i:s', strtotime($l->created_at)) }}</td>
                        <td>{{ $l->accion }}</td>
                        <td>{{ $l->archivo }}</td>
                        <td>{{ $l->Usuarios->name}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script>
    $(function() {
        $("#table-log").DataTable({
            language:{
                url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
            }
        });
    });
</script>
