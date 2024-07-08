@extends('layouts.admin')
@section('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nuevo Ingreso</h3>
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

    <form action="{{ url('compras/ingreso') }}" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="provider">Proveedor</label>
                    <select name="provider_id" id="provider_id" class="form-control selectpicker" data-live-search="true">
                        @foreach ($personas as $persona)
                            <option value="{{$persona->id}}">{{$persona->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="type_voucher">Tipo comprobante</label>
                    <select name="type_voucher" id="" class="form-control">
                        <option value="Boleta">Boleta</option>
                        <option value="Factura">Factura</option>
                        <option value="Ticket">Ticket</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="serial_voucher">Serie comprobante</label>
                    <input type="text" name="serial_voucher"  value="{{ old('serial_voucher') }}" id="" class="form-control" placeholder="Serie comprobante...">
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="number_voucher">Número de comprobante</label>
                    <input type="text" name="number_voucher" required value="{{ old('number_voucher') }}" id="" class="form-control" placeholder="Número de comprobante...">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="">Articulo</label>
                            <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                                @foreach ($articulos as $art)
                                    <option value="{{$art->id}}">{{$art->articulo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="quantity">Cantidad</label>
                            <input type="number" name="pquantity" id="pquantity" min="0" class="form-control" placeholder="Cantidad...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="purchase_price">Precio de compra</label>
                            <input type="number" name="ppurchase_price" id="ppurchase_price" min="0" step="0.10" class="form-control" placeholder="P. compra...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="purchase_sale">Precio de venta</label>
                            <input type="number" name="ppurchase_sale" id="ppurchase_sale" min="0" step="0.10" class="form-control" placeholder="P. venta...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-2 col-xs-12">
                        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                            <thead style="background-color: aqua">
                                <th>Opciones</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Precio compra</th>
                                <th>Precio venta</th>
                                <th>Subtotal</th>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h4 id="total">S/. 0.00</h4></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" id="guardar">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        </div>
        
    </form>


@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#bt_add').click(function(){
                agregar();
            });
        });

        let cont=0;
        total=0;
        subtotal=[];
        $("#guardar").hide();

        function agregar(){
            idarticulo=$("#pidarticulo").val();
            articulo=$("#pidarticulo option:selected").text();
            cantidad=$("#pquantity").val();
            precio_compra=$("#ppurchase_price").val();
            precio_venta=$("#ppurchase_sale").val("");

            if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!=""){
                subtotal[cont]=(cantidad*precio_compra);
                total=total+subtotal[cont];
                
                let fila='<tr class="selected" id="fila'+cont'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
                cont++;
                limpiar();
                $("#total").html("S/. "+total);
            }
        }
        function limpiar(){
            $("#pquantity").val("");
            $("#pppurchase_price").val("");
            $("#ppurchase_sale").val("");
        }
        function evaluar(){
            if(total>0){
                $("#guardar").show();
            }
            else{
                $("#guardar").hide();
            }
        }
    </script>
@endpush