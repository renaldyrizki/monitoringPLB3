@extends('layouts.backend.'.config('larakuy.theme_back').'.app')



@section('breadcrumbs')
    {!! Breadcrumbs::render('truckPermits') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex no-block">
                    <div class="ml-auto" style="margin-left: 0.2in; margin-bottom: 10px;">
                        <a href="{{ route('backend::truckPermits_add') }}" class="btn btn-sm btn-success btn-md" href="#">
                            <i class="fa fa-plus"></i> Tambah Data Truk
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>Nomor Truk</th>
                                <th>Perusahaan Transporter</th>
                                <th>Lampiran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=0;?>
                        @forelse($data as $truck)
                            <tr>
                                <td>
                                    <a class="btn btn-info btn-xs" title="Ubah" href="{{route('backend::truckPermits_edit', ['id' => $truck->id_truck])}}"> Ubah
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-danger btn-xs" title="Hapus" onclick="deleteData({{ $truck->id_truck }})"> Hapus
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td style="width: 20px">
                                    {{ $no + $data->firstItem()}}
                                </td>
                                <td>
                                    {{ $truck->no_polisi }} 
                                </td>
                                <td>
                                    {{ $truck->perusahaan_transporter }} 
                                </td>
                                <td>
                                    @if($truck->izin_pengangkutan_file or $truck->dokumen_lingkungan_file or $truck->mou_file or $truck->kartu_pengawasan_file)
                                        <a href="{{ route('backend::truckPermits_downloads', ['id' => $truck->id_truck]) }}"><u>Download</u></a>
                                    @else
                                        Tidak Ada
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $file = array('izin_pengangkutan', 'dokumen_lingkungan', 'mou','kartu_pengawasan');
                                        $status = 1;
                                        $i = 0;
                                        while ($i < count($file) and $status==1) {
                                            if($truck[$file[$i]."_tanggal_terbit"] and $truck[$file[$i]."_tanggal_habis"] and $truck[$file[$i]."_file"]){
                                                $habis = date("Y-m-d", strtotime($truck[$file[$i]."_tanggal_habis"]));
                                                $hariIni = date("Y-m-d", strtotime("now"));
                                                if ($hariIni > $habis) {
                                                    $status = 0;
                                                };
                                            }else{
                                                $status = 0;
                                            };
                                            $i = $i+1;
                                        };
                                        if($status == 1){
                                            echo "Lengkap";
                                        }else{
                                            echo "Tidak Lengkap";
                                        };
                                    @endphp
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
                    <div class="col-md-12 text-center">
                        {{ $data->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
  table {
    /* border-collapse: collapse; */
  }
  
  table, th, td, tr, thead, tbody, .table>thead>tr>th {
    border-bottom: 1px solid black;
  }
  .table{
    width: 98%;
    max-width: 98%;
    margin-right: 1%;
    margin-left: 1%;
  }


  /* .table>thead>tr>th {
    border-bottom: 1px solid black;
  } */
</style>

@endpush

@push('script')
<script type="text/javascript">
    function deleteData(id){
        console.log(id);
		$('#mdlHapus'+id).modal('show'); // show bootstrap modal
	}
</script>


@foreach($data as $res)
<div id="mdlHapus{{$res->id_truck}}" class="modal fade" tabindex="-1">
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
                <form method="POST" action="{{ route('backend::truckPermits_delete', ['id'=>$res->id_truck]) }}" accept-charset="UTF-8">
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