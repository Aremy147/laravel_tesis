<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$per->id}}">
    <form action="{{route('proveedor.destroy',$per->id)}}" method="post">
        @csrf
        @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title">Eliminar proveedor</h4>
            </div>
            <div class="modal-body">
                <p>Confirme si desea Eliminar el proveedor</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </form>
</div>