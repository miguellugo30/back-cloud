<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="razon-social">Razon Social *:</label>
            <input type="text" class="form-control form-control-sm" id="razon_social" placeholder="Razon Social" value="{{ $empresa->razon_social }}">
            @csrf
        </div>
        <div class="form-group">
            <label for="calle">Intercompañia :</label>
            <input type="text" class="form-control form-control-sm" id="intercompania" placeholder="Intercompañia" value="{{ $empresa->intercompania }}">
        </div>
    </div>
</div>
