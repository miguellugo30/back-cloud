@if (\Str::endsWith($file,['jpeg', 'jpg', 'png', 'ico']))

    <img src="{{$file}}" alt="">

@elseif (\Str::endsWith($file,['doc', 'docx', 'xlsx', 'xls']))

    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{url($file)}}" frameborder="0" style="width: 100%;min-height:440px"></iframe>

@elseif (\Str::endsWith($file,['pdf']))

    <iframe src="{{$file}}" frameborder="0" style="width: 100%;min-height:440px"></iframe>

@else
    <i class="fas fa-file fa-2x"></i>
@endif
