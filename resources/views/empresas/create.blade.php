<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="razon-social">Razon Social *:</label>
            <input type="text" class="form-control form-control-sm" id="razon_social" placeholder="Razon Social">
            @csrf
        </div>
        <div class="form-group">
            <label for="calle">Calle :</label>
            <input type="text" class="form-control form-control-sm" id="calle" placeholder="Calle">
        </div>
        <div class="form-group">
            <label for="colonia">Colonia :</label>
            <input type="text" class="form-control form-control-sm" id="colonia" placeholder="Colonia">
        </div>
        <div class="form-group">
            <label for="cp">C.P. :</label>
            <input type="text" class="form-control form-control-sm" id="cp" placeholder="C.P.">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="rfc">RFC *:</label>
            <input type="text" class="form-control form-control-sm" id="rfc" placeholder="RFC">
        </div>
        <div class="form-group">
            <label for="numero">Numero :</label>
            <input type="text" class="form-control form-control-sm" id="numero" placeholder="Numero">
        </div>
        <div class="form-group">
            <label for="municipio">Municipio :</label>
            <input type="text" class="form-control form-control-sm" id="municipio" placeholder="Municipio">
        </div>
    </div>
</div>
    <div class="col">
        <div class="form-group">
            <label for="telefono_1">Teléfono*:</label>
            <input type="text" class="form-control form-control-sm" id="telefono_1" placeholder="Teléfono">
        </div>
        <div class="form-group">
            <label for="telefono_2">Teléfono:</label>
            <input type="text" class="form-control form-control-sm" id="telefono_2" placeholder="Teléfono">
        </div>
        <div class="form-group">
            <label for="sitio_web">Sitio Web:</label>
            <input type="text" class="form-control form-control-sm" id="sitio_web" placeholder="Sitio Web">
        </div>
        <div class="form-group">
            <small class="form-text text-muted"> <b>*Campos obligatorios.</b></small>
        </div>
        <div class="alert alert-danger print-error-msg" role="alert" style="display:none">
            <ul></ul>
        </div>
    </div>
