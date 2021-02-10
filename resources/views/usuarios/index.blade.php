<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i>
            Usuarios
          </h3>
          <div class="card-tools">
            @can('delete usuarios')
                <button type="button" class="btn btn-danger btn-sm deleteUsuario" style="display:none"><i class="fas fa-trash-alt"></i> Elminar</button>
            @endcan
            @can('edit usuarios')
                <button type="button" class="btn btn-warning btn-sm editUsuario" style="display:none"><i class="fas fa-edit"></i> Editar</button>
            @endcan
            @can('create usuarios')
                <button type="button" class="btn btn-primary btn-sm newUsuario"><i class="fas fa-plus"></i> Nuevo</button>
            @endcan
                <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="">
        </div>
    </div>
    <div class="card-body">
        <table id="table-usuarios" class="table table-sm">
            <thead class="thead-light">
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono Fijo</th>
                <th>Teléfono Movil</th>
                <th>Extensión</th>
                <th>Empresa</th>
                <th>Rol</th>
            </thead>
            <tbody>
                @foreach ($usuarios as $u)
                    <tr data-id="{{ $u->id }}">
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->DatosUsuarios->telefono_fijo }}</td>
                        <td>{{ $u->DatosUsuarios->telefono_movil }}</td>
                        <td>{{ $u->DatosUsuarios->extension }}</td>
                        <td>{{ $u->Empresas->first()->razon_social }}</td>
                        <td>{{ $u->getRoleNames()->first() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">
                    ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-sm btn-primary" id="action"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->
