@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de clientes <a href="cliente/create"><button class="btn btn-success">Nuevo</button></a></h3>
            @include('ventas.cliente.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Tipo Doc</th>
                        <th>Número Doc</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($personas as $per)
                        <tr>
                            <td>{{$per->id}}</td>
                            <td>{{$per->name}}</td>
                            <td>{{$per->type_document}}</td>
                            <td>{{$per->n_document}}</td>
                            <td>{{$per->phone}}</td>
                            <td>{{$per->address}}  {{$per->region}}-{{$per->province}}-{{$per->district}}</td>
                            <td>
                                <a href="{{route('cliente.edit',$per->id)}}"><button class="btn btn-info">Editar</button></a>
                                <a href="" data-target="#modal-delete-{{$per->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
                            </td>
                        </tr>
                        @include('ventas.cliente.modal')
                    @endforeach
                </table>
            </div>
            {{$personas->render()}}
        </div>
    </div>
@endsection