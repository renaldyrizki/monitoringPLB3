@extends('layouts.backend.'.config('larakuy.theme_back').'.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('pengangkutanLimbahB3_tabelData') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex no-block">
                   <div class="ml-auto">
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::pengangkutanLimbahB3_add') }}">
                            <i class="fa fa-plus"></i> Buat
                        </a>
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::pengangkutanLimbahB3_add') }}">
                            <i class="fa fa-book"></i> Download Logbook
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="icon fa fa-check"></i> {{ session('success') }}
                </div>
                @endif

                {{-- <div id="filter" style="margin-top: 0.1in;">
                    <!-- <a href="">Semua</a> |  -->
                    <form class="form-inline" action="{{ route('gerbang::banner.index') }}" method="GET">
                        <input type="text" name="judul" class="form-control form-control-sm" placeholder="Judul Banner" style="margin-left: 0; border-width: 1px;">
                        <input id="sbmt" type="submit" class="btn btn-success btn-sm" value="Cari" style="margin-left: 0.2in;">
                    </form>
                </div> --}}

                <div class="table-responsive m-t-20">
                    <table class="table table-hover" >
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>Jenis Limbah B3 Yang Keluar</th>
                                <th>Tanggal Keluar</th>
                                <th>Jumlah Keluar</th>
                                <th>Tujuan Penyerahan</th>
                                <th>Nomor Manifest</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0;?>
                        @forelse($data as $res)
                        <tr>
                            <td>
                                <a class="btn btn-info btn-xs" title="Ubah" href="{{ route('backend::pengangkutanLimbahB3_edit', ['id' => $res->id_pengangkutan]) }}"> Ubah
                                {{-- <a class="btn btn-info btn-xs" title="Ubah"> Ubah --}}
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData({{ $res->id_pengangkutan }})"> Hapus
                                {{-- <button class="btn btn-danger btn-xs" title="Hapus"> Hapus --}}
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </td>
                            <td>
                                {{ $no + $data->firstItem()}}
                            </td>
                            <td>
                                {{ $res->jenis_limbah }}
                            </td>
                            <td>
                                {{ $res->tanggal_pengangkutan }}
                            </td>
                            <td>
                                {{ $res->total_pengangkutan }}
                            </td>
                            <td>
                                {{ $res->tujuan_pemanfaatan }}
                            </td>
                            <td>
                                {{ $res->nomor_manifest }}
                            </td>
                        </tr>
                        <?php $no++;?>
                        @empty
                        <tr>
                            <td>
                                Tidak ada data.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                    
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>

                    {{-- <div class="col-md-12 text-center">
                    {{ $data->links("pagination::bootstrap-4") }}
                    </div> --}}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    function deleteData(id){
        console.log(id);
		$('#mdlHapus'+id).modal('show'); // show bootstrap modal
	}

    // function lihatFoto(url){
	// 	$("#fotona").attr("src", url);
	// 	$('#modalFoto').modal('show'); // show bootstrap modal
	// }
</script>

@foreach($data as $res)
<div id="mdlHapus{{$res->id_pengangkutan}}" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						Apakah benar data akan di hapus?
					</div>
				</div>
			</div>

			<div class="modal-footer">
                <form method="POST" action="{{ route('backend::pengangkutanLimbahB3_delete', ['id'=>$res->id_pengangkutan]) }}" accept-charset="UTF-8">
                    <input name="_method" type="hidden" value="DELETE">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>

                    <input type="submit" class="btn btn-sm btn-danger" value="Hapus">
                </form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
@endforeach

{{-- <div id="modalFoto" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Lihat Gambar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
						<img src="{{ asset('uploads/default.jpg') }}" id="fotona" width="100%">
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Close
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>	 --}}

@endpush