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
        <div class="form-group">
            <label for="calle">Ruta Respaldo *:</label>
            <input type="text" class="form-control form-control-sm" id="url_respaldo" placeholder="Ruta Respaldo" value="{{ $empresa->url_respaldo }}">
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
            <input type="number" min="1" max="7" class="form-control form-control-sm" id="no_respaldos" placeholder="Número de Respaldos" value="{{ $empresa->no_respaldos }}">
        </div>
        <div class="form-group">
            <label for="calle">Respaldo semanal:</label>
            <select name="dia_semana" id="dia_semana" class="form-control form-control-sm">
                <option value="">Selecciona una opción</option>
                <option value="Monday"  {{ $empresa->dia_semana == "Monday" ? 'selected="selected"' : '' }}>Lunes</option>
                <option value="Tuesday"  {{ $empresa->dia_semana == "Tuesday" ? 'selected="selected"' : '' }}>Martes</option>
                <option value="Wednesday"  {{ $empresa->dia_semana == "Wednesday" ? 'selected="selected"' : '' }}>Miercoles</option>
                <option value="Thursday"  {{ $empresa->dia_semana == "Thursday" ? 'selected="selected"' : '' }}>Jueves</option>
                <option value="Friday"  {{ $empresa->dia_semana == "Friday" ? 'selected="selected"' : '' }}>Viernes</option>
                <option value="Saturday"  {{ $empresa->dia_semana == "Saturday" ? 'selected="selected"' : '' }}>Sabado</option>
                <option value="Sunday"  {{ $empresa->dia_semana == "Sunday" ? 'selected="selected"' : '' }}>Domingo</option>
            </select>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="fin_mes" {{ $empresa->fin_mes == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="defaultCheck1">
                Conservar el respaldo de cada fin de mes.
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="ultimo_anio" {{ $empresa->ultimo_anio == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="defaultCheck1">
                Conservar el ultimo del año.
            </label>
        </div>
    </div>
</div>
