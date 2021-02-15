<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="name">Nombre *:</label>
            <input type="text" class="form-control form-control-sm" id="name" placeholder="Nombre usuario">
            @csrf
        </div>
        <div class="form-group">
            <label for="email">Email *:</label>
            <input type="text" class="form-control form-control-sm" id="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="pass_1">Contraseña *:</label>
            <input type="password" class="form-control form-control-sm" id="password" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="pass_2">Confirmar contraseña *:</label>
            <input type="password" class="form-control form-control-sm" id="password_confirmation" placeholder="Contraseña">
        </div>
        <div class="form-group">
            <label for="tel_movil">Teléfono Móvil :</label>
            <input type="text" class="form-control form-control-sm" id="tel_movil" placeholder="Teléfono Móvil">
        </div>
        <div class="form-group">
            <label for="tel_fijo">Teléfono Fijo :</label>
            <input type="text" class="form-control form-control-sm" id="tel_fijo" placeholder="Teléfono Fijo">
        </div>
        <div class="form-group">
            <label for="extension">Extensión :</label>
            <input type="text" class="form-control form-control-sm" id="extension" placeholder="Extensión">
        </div>
        <div class="form-group">
            <label for="rol">Empresa *:</label>
            <select name="empresa" id="empresa" class="form-control form-control-sm">
                <option value="">Selecciona una empresa</option>
                @foreach( $empresas as $empresa )
                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="rol">Roles *:</label>
            <select name="rol" id="rol" class="form-control form-control-sm">
                <option value="">Selecciona un rol</option>
                @foreach( $roles as $rol )
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
        </div>
        <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
            <ul></ul>
        </div>
    </div>
    <div class="col modulosEmpresa">

        <h5><b>Permisos</b></h5>
        <div class="col">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <table class="table table-striped table-sm">
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <input type="checkbox" class="permisos_config" name="permisos[]" id="permisos[]" data-value="empresas" value="view empresas"> Empresas
                            </td>
                        </tr>
                        <tr style="display:none" class="permisos permisos_config_empresas" id="permisos_empresas">
                            <td>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="create empresas">
                                        <i class="fas fa-folder-plus"></i>
                                        Crear Empresas
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="edit empresas">
                                        <i class="far fa-edit"></i>
                                        Editar Empresas
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="delete empresas">
                                        <i class="fas fa-trash"></i>
                                        Eliminar Empresas
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <input type="checkbox" class="permisos_config" name="permisos[]" id="permisos[]" data-value="usuarios" value="view usuarios"> Usuarios
                            </td>
                        </tr>
                        <tr style="display:none" class="permisos permisos_config_usuarios" id="permisos_usuarios">
                            <td>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="create usuarios">
                                        <i class="fas fa-folder-plus"></i>
                                        Crear Usuarios
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="edit usuarios">
                                        <i class="far fa-edit"></i>
                                        Editar Usuarios
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" name="permisos[]" id="permisos[]" value="delete usuarios">
                                        <i class="fas fa-trash"></i>
                                        Eliminar Usuarios
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @foreach( $empresas as $empresa )
                            <tr>
                                <td colspan="5">
                                    <input type="checkbox" class="views_empresas view_empresa_{{ $empresa->id }}" name="permisos[]" id="permisos[]" data-value="{{ $empresa->id }}" value="view_empresa_{{ $empresa->id }}" > {{ $empresa->razon_social }}
                                </td>
                            </tr>
                            <tr style="display:none" class="permisos_empresas" id="permisos_empresa_{{ $empresa->id }}">
                                <td>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <input type="checkbox" name="permisos[]" id="permisos[]" value="create_empresa_{{ $empresa->id }}">
                                            <i class="fas fa-folder-plus"></i>
                                            Crear Carpetas
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" name="permisos[]" id="permisos[]" value="upload_empresa_{{ $empresa->id }}">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            Subir Archivos
                                        </li>
                                        <!--li class="list-group-item">
                                            <input type="checkbox" name="permisos[]" id="permisos[]" value="edit_empresa_{{-- $empresa->id --}}">
                                            <i class="far fa-edit"></i>
                                            Editar Archivos
                                        </li-->
                                        <li class="list-group-item">
                                            <input type="checkbox" name="permisos[]" id="permisos[]" value="delete_empresa_{{ $empresa->id }}">
                                            <i class="fas fa-trash"></i>
                                            Eliminar Archivos
                                        </li>
                                        <li class="list-group-item">
                                            <input type="checkbox" name="permisos[]" id="permisos[]" value="donwload_empresa_{{ $empresa->id }}">
                                            <i class="fas fa-cloud-download-alt"></i>
                                            Descargar Archivos
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
    </div>
</div>
