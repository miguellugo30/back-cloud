<div class="form-group">
    @csrf
    <label for="rol">Empresa: {{$conexion->Empresas->razon_social}}</label>

</div>
<div class="form-group">
    <label for="rol">Ruta *:</label>
    <input type="text" class="form-control form-control-sm" id="ruta" placeholder="Ruta" value="{{ $conexion->ruta }}">
</div>
<div class="row">
    <table class="table">
        <thead class="thead-light">
            <tr>
                <td scope="col">#</td>
                <td scope="col">Host</td>
                <td scope="col">Puerto</td>
                <td scope="col">Usuario</td>
                <td scope="col">Contraseña</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if ($conexion->prioridad == 1)
                        Principal
                    @else
                        Secundario
                    @endif
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="host_principal" placeholder="Host" value="{{ \Crypt::decryptString($conexion->host) }}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="puerto_principal" placeholder="Puerto" value="{{ \Crypt::decryptString($conexion->puerto) }}">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="usuario_principal" placeholder="Usuario" value="{{ \Crypt::decryptString($conexion->usuario) }}">
                </td>
                <td>
                    <input type="password" class="form-control form-control-sm" id="contrasena_principal" placeholder="Contraseña" value="{{ \Crypt::decryptString($conexion->contrasena) }}">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>

