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
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::permitsControl_add') }}">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                        <a class="btn btn-sm btn-success btn-md" href="{{ route('backend::kirimEmail_permits')}}">
                            <i class="fa fa-envelope"></i> Report Email
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
                <div id="filter" style="margin-top: 0.1in; margin-bottom: 0.1in;">
                    <form class="form-inline" action="{{ route('backend::permitsControl') }}" method="GET">
                    {{-- <form class="form-inline" action="" method="GET" style="margin-left: 0.2in; margin-bottom: 10px;"> --}}
                        <div class="form-group" row>
                            <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari Perusahaan" style="margin-left: 0; border-width: 1px;">
                        </div>
                        <div class="form-group" row>
                            <select name="jenis_perizinan" class="form-control">
                                <option disabled selected value> -- Jenis Perizinan -- </option>
                                @foreach($jenis_perizinan as $key => $value)
                                    <option value={{$key}}>{{$value}}</option>
                                @endforeach
                                </optgroup>
                            </select>
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
                    <table class="table table-hover" >
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>No Surat Keputusan</th>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Terbit</th>
                                <th>Tanggal Habis Berlaku</th>
                                <th>Jenis Perizinan</th>
                                <th>Lampiran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0;?>
                        @forelse($data as $res)
                            <tr>
                                <td>
                                        <a class="btn btn-info btn-xs" title="Ubah" href="{{ route('backend::permitsControl_edit', ['id' => $res->id_permits]) }}"> Ubah
                                        {{-- <a class="btn btn-info btn-xs" title="Ubah"> Ubah --}}
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData({{ $res->id_permits }})"> Hapus
                                        {{-- <button class="btn btn-danger btn-xs" title="Hapus"> Hapus --}}
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </td>
                                <td>
                                    {{ $no + $data->firstItem()}}
                                </td>
                                <td>
                                    {{ $res->no_surat_keputusan }}
                                </td>
                                <td>
                                    {{ $res->nama_perusahaan }}
                                </td>
                                <td>
                                    {{ $res->tanggal_terbit }}
                                </td>
                                <td>
                                    {{ $res->tanggal_habis_berlaku }}
                                </td>
                                <td>
                                    {{ $res->jenis_perizinan }}
                                </td>
                                <td>
                                    @if($res->lampiran_dokumen)
                                        <a href="{{ route('backend::permitsControl_download', ['id' => $res->id_permits]) }}"><u>Download</u></a>
                                    @else
                                        Tidak Ada
                                    @endif
                                </td>
                                <td>
                                    @php 
                                        $terbit = date("Y-m-d", strtotime($res->tanggal_terbit));
                                        $habis = date("Y-m-d", strtotime($res->tanggal_habis_berlaku));
                                        $batas = date("Y-m-d", strtotime("-2 month", strtotime($res->tanggal_habis_berlaku)));
                                        $hariIni = date("Y-m-d", strtotime("now"));
                                    @endphp
                                    @if( ($hariIni > $batas) and ($hariIni <= $habis))
                                        Warning
                                    @elseif ($hariIni > $habis)
                                        Expired
                                    @elseif ($hariIni <= $batas)
                                        OK
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
<div id="mdlHapus{{$res->id_permits}}" class="modal fade" tabindex="-1">
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
                <form method="POST" action="{{ route('backend::permitsControl_delete', ['id'=>$res->id_permits]) }}" accept-charset="UTF-8">
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