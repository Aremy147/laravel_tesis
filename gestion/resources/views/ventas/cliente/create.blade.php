@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nuevo cliente</h3>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <form action="{{ url('ventas/cliente') }}" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" required value="{{ old('name') }}" id=""
                        class="form-control" placeholder="Nombre...">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="name">Tipo documento</label>
                    <select name="type_document" id="" class="form-control">
                        <option value="DNI">DNI</option>
                        <option value="RUC">RUC</option>
                        <option value="PAS">PAS</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="n_document">Número de documento</label>
                    <input type="text" name="n_document" required value="{{ old('n_document') }}" id=""
                        class="form-control" placeholder="N° documento...">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" required value="{{ old('address') }}" id=""
                        class="form-control" placeholder="Direccion...">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="region">Departamento:</label>
                    <select id="region" name="region" class="form-control">
                        <option value="">Selecciona un departamento</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="province">Provincia:</label>
                    <select id="province" name="province" class="form-control" disabled>
                        <option value="">Selecciona una provincia</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="district">Distrito:</label>
                    <select id="district" name="district" class="form-control" disabled>
                        <option value="">Selecciona un distrito</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="phone">Telefono</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" id=""
                        class="form-control" placeholder="Telefono...">
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" required value="{{ old('email') }}" id=""
                        class="form-control" placeholder="Email...">
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>

    </form>


@endsection
@push('scripts')
    <script src="{{asset('js/script.js')}}"></script>
@endpush