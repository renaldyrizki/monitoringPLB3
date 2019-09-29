@extends('layouts.backend.'.config('larakuy.theme_back').'.app')



@section('breadcrumbs')
    {!! Breadcrumbs::render('mouControl') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i> {{ session('success') }}
                    </div>
                @endif
                <div id="filter" style="margin-top: 0.1in; margin-bottom: 0.1in;">
                    <form class="form-inline" action="{{ route('backend::mouControl') }}" method="GET">
                        <div class="form-group" row>
                            <input  type="text" name="kata_kunci" class="form-control form-control-sm" placeholder="Kata Kunci" style="margin-left: 0; border-width: 1px;">
                        </div>
                        <div class="form-group" row>
                            <input type="text" name="nomor_kontrak" class="form-control form-control-sm" placeholder="Nomor Kontrak" style="margin-left: 0; border-width: 1px;">
                        </div>
                        <div class="form-group" row>
                            <select name="status" class="form-control">
                                <option disabled selected value> -- Status -- </option>
                                @foreach($status as $key => $value)
                                    <option value={{$key}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" row>
                            <select name="sort_by" class="form-control">
                                <option disabled selected value> -- Sort By -- </option>
                                @foreach($sort_by as $value)
                                    <option value={{ str_replace(" ", "_", strtolower($value)) }}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" row>
                            <select name="sort" class="form-control">
                                <option value='asc'>Ascending</option>
                                <option value='desc'>Descending</option>
                            </select>
                        </div>
                        <div class="form-group" style="margin:5px">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            {{-- <input id="sbmt" type="submit" class="btn btn-success btn-sm fa fa-plus" value="Cari"> --}}
                            <a class="btn btn-success btn-sm" role="button" href=""><i class="fa fa-recycle"></i> Reset</a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive m-t-20">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>No</th>
                                <th>Perusahaan Pengelola Lanjut</th>
                                <th>Tipe Pengelolaan</th>
                                <th>Nomor Kontrak</th>
                                <th>Tanggal Kontrak</th>
                                <th>Tanggal Habis Berlaku Kontrak</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0;?>
                        @forelse($data as $res)
                        <tr>
                            <td>
                                <a class="btn btn-info btn-xs" title="Ubah" href="{{ route('backend::mouControl_edit', ['id' => $res->id_mou]) }}"> Ubah
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData({{ $res->id_mou }})"> Hapus
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            <td>
                                {{ $no + $data->firstItem()}}
                            </td>
                            <td>
                                {{ $res->perusahaan_pengelola_lanjut}}
                            </td>
                            <td>
                                {{ $res->tipe_pengelolaan}}
                            </td>
                            <td>
                                {{ $res->nomor_kontrak}}
                            </td>
                            <td>
                                {{ $res->tanggal_terbit_kontrak}}
                             </td>
                             <td>
                                {{ $res->tanggal_habis_berlaku_kontrak}}
                             </td>
                            <td>
                                @if ($res->status_kontrak==1)
                                    Diterima
                                @else
                                    Belum Diterima
                                @endif
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
                    {{-- {{ $data->links("pagination::bootstrap-4") }} --}}
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

    // function lihatFoto(url){
	// 	$("#fotona").attr("src", url);
	// 	$('#modalFoto').modal('show'); // show bootstrap modal
	// }
</script>

@foreach($data as $res)
<div id="mdlHapus{{$res->id_mou}}" class="modal fade" tabindex="-1">
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
                <form method="POST" action="{{ route('backend::mouControl_delete', ['id'=>$res->id_mou]) }}" accept-charset="UTF-8">
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