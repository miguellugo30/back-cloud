<div class="form-group">
    @csrf
    <label for="rol">Empresa *:</label>
    <select name="empresa" id="empresa" class="form-control form-control-sm">
        <option value="">Selecciona una empresa</option>
        @foreach( $empresas as $empresa )
        <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="rol">Ruta *:</label>
    <input type="text" class="form-control form-control-sm" id="ruta" placeholder="Ruta">
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
                    Principal
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="host_principal" placeholder="Host">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="puerto_principal" placeholder="Puerto">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="usuario_principal" placeholder="Usuario">
                </td>
                <td>
                    <input type="password" class="form-control form-control-sm" id="contrasena_principal" placeholder="Contraseña">
                </td>
            </tr>
            <tr>
                <td>
                    Secundario
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="host_secundario" placeholder="Host">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="puerto_secundario" placeholder="Puerto">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="usuario_secundario" placeholder="Usuario">
                </td>
                <td>
                    <input type="password" class="form-control form-control-sm" id="contrasena_secundario" placeholder="Contraseña">
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>

