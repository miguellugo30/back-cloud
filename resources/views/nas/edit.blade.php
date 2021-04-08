<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="razon-social">Nombre *:</label>
            <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre" value="{{ $nas->Nombre }}">
            @csrf
        </div>
        <div class="form-group">
            <label for="calle">Ruta* :</label>
            <input type="text" class="form-control form-control-sm" id="ruta" placeholder="Ruta" value="{{ $nas->ruta }}">
        </div>
    </div>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
