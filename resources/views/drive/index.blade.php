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
                    <button type="button" id="viewList" class="btn btn-info"><i class="fas fa-list"></i> </button>
                    <button type="button" id="viewIcons" class="btn btn-info"><i class="fas fa-th"></i> </button>

                    @can('donwload_empresa_'.$id)
                        <button type="button" id="downloadFile" class="btn btn-primary" style="display: none"><i class="fas fa-cloud-download-alt"></i> Descargar</button>
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
