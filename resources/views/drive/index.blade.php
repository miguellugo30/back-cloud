<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-hdd"></i>
            @php
                $ruta = explode('/', $url);
                @endphp
            @if ( count($ruta) > 1 )
                @php
                    $url_return = $ruta[0];
                @endphp
                DRIVE : <i class="fas fa-home return" data-url_return="{{$ruta[0]}}" style="cursor: pointer"></i>
                @for ($i = 1; $i < count($ruta); $i++)

                    @php
                        $url_return .= '/'.$ruta[$i]
                    @endphp

                    @if ( $i ==  ( count($ruta) - 1 ) )
                        >  <a> {{ $ruta[$i]}}</a>
                    @else
                        >  <a class="return" data-url_return="{{$url_return}}" style="cursor: pointer"> {{ $ruta[$i]}}</a>
                    @endif
                @endfor

            @else
                DRIVE : <i class="fas fa-home" data-url_return="{{$ruta[0]}}"></i>
            @endif

        </h3>
          <div class="card-tools">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        @can('donwload_empresa_'.$id)
                        <button type="button" id="downloadFile" class="btn btn-primary" style="display: none"><i class="fas fa-cloud-download-alt"></i> Descargar Archivo</button>
                    @endcan
                    @can('delete_empresa_'.$id)
                        <button type="button" id="deleteFile" class="btn btn-danger" style="display: none"><i class="fas fa-trash"></i> Eliminar</button>
                    @endcan
                </div>
               <input type="hidden" name="idSeleccionado" id="idSeleccionado" value="{{ $id }}">
               <input type="hidden" name="ruta" id="ruta" value="{{ $url }}">
               <input type="hidden" name="fileSelected" id="fileSelected" value="">
               <input type="hidden" name="fileSelectedType" id="fileSelectedType" value="">
               @csrf
        </div><!-- card-tools -->
    </div><!-- card-header -->
    <div class="card-body">
        <div class="container">
            <div class="row row-cols-7 justify-content-start">
                <div class="col">
                    <h6>Directorios</h6>
                    <hr>
                </div>
                <div class="w-100"></div>
                @foreach ($directories as $d)
                    <div class="col-2 text-center selectFile" style="cursor: pointer" data-type="directory" data-url="{{ $d }}">
                        @if (\Str::endsWith($d,'lera'))
                            <i class="far fa-trash-alt fa-2x text-info"></i>
                        @else
                            <i class="fas fa-folder fa-2x text-warning"></i>
                        @endif

                        @php
                            $di = explode('/', $d);
                        @endphp

                        <p>
                            @if ( count($di) > 1 )
                                {{$di[ count($di) -1  ]}}
                            @else
                                {{$di[0]}}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div><!-- row -->
            <hr>
            <div class="row row-cols-7 justify-content-start" >
                <div class="col">
                    <h6>Archivos</h6>
                    <hr>
                </div>
                <div class="w-100"></div>
                @foreach ($files as $f)
                    <div class="col-2 text-center selectFile pt-3" style="cursor: pointer" data-type="file" data-url="{{ $f }}">
                        @if (\Str::endsWith($f,['jpeg', 'jpg', 'png']))
                            <i class="far fa-file-image fa-2x text-info"></i>
                        @elseif (\Str::endsWith($f,['doc', 'docx']))
                            <i class="far fa-file-word fa-2x text-primary"></i>
                        @elseif (\Str::endsWith($f,['xlsx', 'xls', 'xlsm', 'xlsb', 'xltx']))
                            <i class="far fa-file-excel fa-2x text-success"></i>
                        @elseif (\Str::endsWith($f,['pdf']))
                            <i class="far fa-file-pdf fa-2x text-danger"></i>
                        @elseif (\Str::endsWith($f,['txt']))
                            <i class="far fa-file-alt fa-2x text-info"></i>
                        @elseif (\Str::endsWith($f,['ppt','pptx','pptm']))
                            <i class="far fa-file-powerpoint fa-2x text-danger"></i>
                        @elseif (\Str::endsWith($f,['mp3', 'wav' ]))
                            <i class="far fa-file-audio fa-2x text-danger"></i>
                        @elseif (\Str::endsWith($f,['zip', 'rar', 'unzip', 'tar', 'gz' ]))
                            <i class="far fa-file-archive fa-2x text-danger"></i>
                        @else
                            <i class="fas fa-file fa-2x text-info"></i>
                        @endif
                        <p>
                            @php
                                $di = explode('/', $f);
                            @endphp
                            @if ( count($di) > 1 )
                                {{$di[ count($di) -1  ]}}
                            @else
                                {{$di[0]}}
                            @endif
                        </p>
                    </div>
                @endforeach
            </div><!-- row -->
        </div><!-- Container -->
    </div><!-- card-body -->
</div><!-- card -->

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
            <div class="modal-body text-center" id="modal-body">
                    ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <!--button type="button" class="btn btn-sm btn-primary" id="action"><i class="fas fa-save"></i> Guardar</button-->
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->
<!-- MODAL -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" id="modalUploadFile" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body " id="modal-body">
                <form id="formUlploadFile" class="text-center" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" name="newFiles[]" id="newFiles" multiple accept="application/pdf, text/plain, audio/*, video/*, image/*,.zip,.rar,.7zip">
                        <small id="fileHelp" class="form-text text-muted">El tamaño maximo permitido por archivo es de <strong>30 MB</strong>.</small>
                    </div>
                </form>
                <br>
                <div class="row justify-content-md-center">
                    <div class="col-8">
                        <label id="mensajeList"></label>
                        <ul class="list-group list-group-flush text-left" id="listFiles">

                        </ul>
                    </div>
                </div>
                <br>
                <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
                    <ul></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary float-left" data-dismiss="modal"><i class="fas fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-sm btn-primary" id="actionUploadFile"><i class="fas fa-save"></i> Cargar Archivos</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL -->

