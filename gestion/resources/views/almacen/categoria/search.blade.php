<form method="GET" action="{{ url('almacen/categoria') }}" autocomplete="off" role="search">
    @csrf
    <div class="form-group">
        <div class="input-group">
            <input type="text" name="searchText" class="form-control" placeholder="Buscar..." value="{{ $searchText }}">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </span>
        </div>
    </div>
</form>