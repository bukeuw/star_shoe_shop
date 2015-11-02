<div class="modal fade" id="confirmModal{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
            </div>
            <div class="modal-body">
                <form action="{{ $url }}" method="POST">

                    {!! csrf_field() !!}

                    {!! method_field('DELETE') !!}

                    <p>Apakah Anda yakin ingin menghapus {{ $type }} '{{ $name }}' ?</p>
                    
                    <button id="btnYes{{ $id }}" class="btn btn-warning" type="submit">Yes</button>
                    <button id="btnCancel{{ $id }}" class="btn btn-default" type="button" data-dismiss="modal">No</button>
                </form>
            </div>
        </div>
    </div>
</div>