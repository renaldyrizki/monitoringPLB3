@extends('layouts.backend.'.config('larakuy.theme_back').'.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('penyimpananLimbahB3_tabelData') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex no-block">
                    <div class="ml-auto">
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::penyimpananLimbahB3_add') }}">
                            <i class="fa fa-plus"></i> Buat
                        </a>
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::penyimpananLimbahB3_logbook')}}">
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
                <div class="table-responsive m-t-20">
                    <table class="table table-hover" >
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>ID Penyimpanan</th>
                                <th>Jenis Limbah B3</th>
                                <th>Tanggal Masuk</th>
                                <th>Sumber Limbah B3</th>
                                <th>Jumlah Limbah B3</th>
                                <th>Maksimal Penyimpanan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0;?>
                        @forelse($data as $res)
                            <tr>
                                <td>
                                        <a class="btn btn-info btn-xs" title="Ubah" href="{{ route('backend::penyimpananLimbahB3_edit', ['id' => $res->id_penyimpanan]) }}"> Ubah
                                        {{-- <a class="btn btn-info btn-xs" title="Ubah"> Ubah --}}
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData({{ $res->id_penyimpanan }})"> Hapus
                                        {{-- <button class="btn btn-danger btn-xs" title="Hapus"> Hapus --}}
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </td>
                                <td>
                                    {{ $no + $data->firstItem()}}
                                </td>
                                <td>
                                    {{ $res->id_penyimpanan }}
                                </td>
                                <td>
                                    {{ $res->jenis_limbah }}
                                </td>
                                <td>
                                    {{ date("d-m-Y", strtotime($res->tanggal_penyimpanan)) }}
                                </td>
                                <td>
                                    {{ $res->sumber_limbah }}
                                </td>
                                <td>
                                    {{ $res->total_penyimpanan }}
                                </td>
                                <td>
                                    {{ date("d-m-Y", strtotime($res->tanggal_expired)) }}
                                    {{-- {{ Date("d-m-Y", strtotime("+" day", strtotime($res->tanggal_penyimpanan)))}} --}}
                                </td>
                            </tr>
                            <?php $no++;?>
                            @empty
                            <tr>
                                <td colspan="6">
                                Tidak ada data.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="text-center">
                        {{ $data->links() }}
                    </div>

                    {{-- <div class="col-md-12 text-center"> --}}
                    {{-- {{ $page_name }} --}}
                    {{-- </div> --}}
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
</script>

@foreach($data as $res)
<div id="mdlHapus{{$res->id_penyimpanan}}" class="modal fade" tabindex="-1">
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
                <form method="POST" action="{{ route('backend::penyimpananLimbahB3_delete', ['id'=>$res->id_penyimpanan]) }}" accept-charset="UTF-8">
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

@endpush