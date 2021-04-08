<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="razon-social">Razón Social *:</label>
            <input type="text" class="form-control form-control-sm" id="razon_social" placeholder="Razon Social">
            @csrf
        </div>
        <div class="form-group">
            <label for="calle">Intercompañia :</label>
            <input type="text" class="form-control form-control-sm" id="intercompania" placeholder="Intercompañia">
        </div>
        <div class="form-group">
            <label for="calle">Ruta Respaldo *:</label>
            <input type="text" class="form-control form-control-sm" id="url_respaldo" placeholder="Ruta Respaldo">
        </div>
        <div class="form-group">
            <label for="calle">Nas *:</label>
            <select name="dia_semana" id="nas" class="form-control form-control-sm">
                <option value="">Selecciona una opción</option>
                @foreach ($nas as $n)
                    <option value="{{$n->id}}">{{$n->Nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="calle">Respaldos diarios* :</label>
            <input type="number" min="1" max="7" class="form-control form-control-sm" id="no_respaldos" placeholder="Número de Respaldos">
        </div>
        <div class="form-group">
            <label for="calle">Respaldo semanal:</label>
            <select name="dia_semana" id="dia_semana" class="form-control form-control-sm">
                <option value="">Selecciona una opción</option>
                <option value="Monday">Lunes</option>
                <option value="Tuesday">Martes</option>
                <option value="Wednesday">Miercoles</option>
                <option value="Thursday">Jueves</option>
                <option value="Friday">Viernes</option>
                <option value="Saturday">Sabado</option>
                <option value="Sunday">Domingo</option>
            </select>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="fin_mes">
            <label class="form-check-label" for="defaultCheck1">
                Conservar el respaldo de cada fin de mes.
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="ultimo_anio">
            <label class="form-check-label" for="defaultCheck1">
                Conservar el ultimo del año.
            </label>
        </div>
    </div>
</div>
<div class="alert alert-danger print-error-msg" role="alert" style="display:none">
    <ul></ul>
</div>
