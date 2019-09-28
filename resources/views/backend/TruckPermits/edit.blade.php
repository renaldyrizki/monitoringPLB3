@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('truckPermits_add') !!}
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i> {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('backend::truckPermits_update', ['id' => $data->id_truck]) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PATCH">
        <div class="form-group" row>
            <label for="jenis_kendaraan" class="col-sm-2 control-label">Jenis Kendaraan</label>
            <div class="col-sm-6">
                <select name="jenis_kendaraan" class="form-control" required>
                    <option value=1 {{ (!empty($data))? ($data->jenis_kendaraan==1) ? ' selected' : '' : '' }}>Terbuka</option>
                    <option value=0 {{ (!empty($data))? ($data->jenis_kendaraan==0) ? ' selected' : '' : '' }}>Tertutup</option>
                </select>
            </div>
        </div>
    
        <div class="form-group">
            <label for="no_polisi" class="col-sm-2 control-label">Nomor Polisi</label>
            <div class="col-sm-6">
                <input type="text" maxlength="7" name="no_polisi" id="no_polisi" class="form-control" value="{{ (!empty($data))? $data->no_polisi : '' }}" placeholder="Nomor Polisi">
            </div>
        </div>

        <div class="form-group">
            <label for="nomor_polisi" class="col-sm-2 control-label">Perusahaan Transporter</label>
            <div class="col-sm-6">
                <input  type="text" name="perusahaan_transporter" id="perusahaan_transporter" class="form-control" value="{{ (!empty($data))? $data->perusahaan_transporter : '' }}" placeholder="Perusahaan Transporter">
            </div>
        </div>
        <div class="form-group" row>
            <label for="jk_limbah" class="col-sm-2 control-label">Jenis dan Kode Limbah</label>
            <div class="col-sm-6">
                <label for="jk_limbah">Mutiple select list (hold shift to select more than one):</label>
                <select name="jk_limbah[]" multiple class="form-control" required>
                    @foreach($jk_limbah as $key => $value)
                        {{-- {{ (!empty($data))? (strpos($data->jenis_kode_limbah, $value)) ? ' selected' : 'huft' : '' }} --}}
                        <option value={{$key}} {{ (!empty($data))? (strpos($data->jenis_kode_limbah, $value)) ? ' selected' : '' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="berat_maksimum_kendaraan" class="col-sm-2 control-label">Berat Max Kendaraan</label>
            <div class="col-sm-6">
                <input  type="number" min=0 name="berat_maksimum_kendaraan" id="berat_maksimum_kendaraan" class="form-control" value="{{ (!empty($data))? $data->berat_maksimum_kendaraan : '' }}" placeholder="Berat dalam satuan KG">
            </div>
        </div>

        <div class="form-group">
            <label for="berat_limbah_dapat_diangkut" class="col-sm-2 control-label">Berat Limbah Dapat Diangkut</label>
            <div class="col-sm-6">
                <input  type="number" min=0 name="berat_limbah_dapat_diangkut" id="berat_limbah_dapat_diangkut" class="form-control" value="{{ (!empty($data))? $data->berat_limbah_dapat_diangkut : '' }}" placeholder="Berat dalam satuan KG">
            </div>
        </div>

        <h3 style="text-align: center">Lampiran</h3>

        <div class="form-group">
                <label for="izin_pengangkutan" class="col-sm-2 control-label">Izin Pengangkutan<br>
                    @if ($data->izin_pengangkutan_tanggal_habis and $data->izin_pengangkutan_tanggal_terbit)
                        @php 
                        $terbit = date("Y-m-d", strtotime($data->izin_pengangkutan_tanggal_terbit));
                        $habis = date("Y-m-d", strtotime($data->izin_pengangkutan_tanggal_habis));
                        $batas = date("Y-m-d", strtotime("-2 month", strtotime($data->izin_pengangkutan_tanggal_habis)));
                        $hariIni = date("Y-m-d", strtotime("now"));
                        @endphp
                        @if( (($hariIni > $batas) and ($hariIni <= $habis)))
                            <i style="background-color: yellow; color: black;">Warning</i>
                        @elseif ($hariIni > $habis)
                            <i style="background-color: red; color: white;">Expired</i>
                        @elseif ($hariIni <= $batas)
                            <i style="background-color: green; color: white;">OK</i>
                        @endif
                    @else
                        <i style="background-color: black; color: white;">Not Submited</i>
                    @endif
                </label>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan" id="izin_pengangkutan" class="form-control" value="{{ (!empty($data))? $data->izin_pengangkutan_nomor : '' }}" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->izin_pengangkutan_tanggal_terbit : '' }}" class="form-control pull-right datepicker" id="izin_pengangkutan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan_tanggal_habis" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->izin_pengangkutan_tanggal_habis : '' }}" class="form-control pull-right datepicker" id="izin_pengangkutan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="izin_pengangkutan_file" class="form-control">
                @if($data->izin_pengangkutan_file)
                    <a href="{{ route('backend::truckPermits_download', ['id' => $data->id_truck, 'lampiran' => 'izin_pengangkutan_file']) }}"><u>Download File Saat Ini</u></a><br>
                @endif
            </div>
            <div class="col-sm-2">
                <small>
                    <b>*Biarkan jika tidak akan diubah.</b>
                    {{-- <br><b>*File yang boleh diupload bertipe pdf dan berukuran maksimal 2mb.</b> --}}
                </small>
            </div>
        </div>

        <div class="form-group">
            <label for="dokumen_lingkungan" class="col-sm-2 control-label">Dokumen Lingkungan<br>
                @if ($data->dokumen_lingkungan_tanggal_habis and $data->dokumen_lingkungan_tanggal_terbit)
                    @php 
                    $terbit = date("Y-m-d", strtotime($data->dokumen_lingkungan_tanggal_terbit));
                    $habis = date("Y-m-d", strtotime($data->dokumen_lingkungan_tanggal_habis));
                    $batas = date("Y-m-d", strtotime("-2 month", strtotime($data->dokumen_lingkungan_tanggal_habis)));
                    $hariIni = date("Y-m-d", strtotime("now"));
                    @endphp
                    @if( (($hariIni > $batas) and ($hariIni <= $habis)))
                        <i style="background-color: yellow; color: black;">Warning</i>
                    @elseif ($hariIni > $habis)
                        <i style="background-color: red; color: white;">Expired</i>
                    @elseif ($hariIni <= $batas)
                        <i style="background-color: green; color: white;">OK</i>
                    @endif
                @else
                    <i style="background-color: black; color: white;">Not Submited</i>
                @endif
            </label>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan" id="dokumen_lingkungan" class="form-control" value="{{ (!empty($data))? $data->dokumen_lingkungan_nomor : '' }}" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->dokumen_lingkungan_tanggal_terbit : '' }}" class="form-control pull-right datepicker" id="dokumen_lingkungan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan_tanggal_habis" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->dokumen_lingkungan_tanggal_habis : '' }}" class="form-control pull-right datepicker" id="dokumen_lingkungan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="dokumen_lingkungan_file" class="form-control">
                @if($data->dokumen_lingkungan_file)
                    <a href="{{ route('backend::truckPermits_download', ['id' => $data->id_truck, 'lampiran' => 'dokumen_lingkungan_file']) }}"><u>Download File Saat Ini</u></a><br>
                @endif
            </div>
            <div class="col-sm-2">
                <small>
                    <b>*Biarkan jika tidak akan diubah.</b>
                    {{-- <br><b>*File yang boleh diupload bertipe pdf dan berukuran maksimal 2mb.</b> --}}
                </small>
            </div>
        </div>

        <div class="form-group">
            <label for="mou" class="col-sm-2 control-label">MOU<br>
                @if ($data->mou_tanggal_habis and $data->mou_tanggal_terbit)
                    @php 
                    $terbit = date("Y-m-d", strtotime($data->mou_tanggal_terbit));
                    $habis = date("Y-m-d", strtotime($data->mou_tanggal_habis));
                    $batas = date("Y-m-d", strtotime("-2 month", strtotime($data->mou_tanggal_habis)));
                    $hariIni = date("Y-m-d", strtotime("now"));
                    @endphp
                    @if( (($hariIni > $batas) and ($hariIni <= $habis)))
                        <i style="background-color: yellow; color: black;">Warning</i>
                    @elseif ($hariIni > $habis)
                        <i style="background-color: red; color: white;">Expired</i>
                    @elseif ($hariIni <= $batas)
                        <i style="background-color: green; color: white;">OK</i>
                    @endif
                @else
                    <i style="background-color: black; color: white;">Not Submittd</i>
                @endif
            </label>
            
            <div class="col-sm-2">
                <input type="text" name="mou" id="mou" class="form-control" value="{{ (!empty($data))? $data->mou_nomor : '' }}" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="mou_tanggal_terbit" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->mou_tanggal_terbit : '' }}" class="form-control pull-right datepicker" id="mou_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="mou_tanggal_habis" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->mou_tanggal_habis : '' }}" class="form-control pull-right datepicker" id="mou_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="mou_file" class="form-control">
                @if($data->mou_file)
                    <a href="{{ route('backend::truckPermits_download', ['id' => $data->id_truck, 'lampiran' => 'mou_file']) }}"><u>Download File Saat Ini</u></a><br>
                @endif
            </div>
            <div class="col-sm-2">
                <small>
                    <b>*Biarkan jika tidak akan diubah.</b>
                    {{-- <br><b>*File yang boleh diupload bertipe pdf dan berukuran maksimal 2mb.</b> --}}
                </small>
            </div>
        </div>
        
        <div class="form-group">
            <label for="kartu_pengawasan" class="col-sm-2 control-label">Kartu Pengawasan<br>
                @if ($data->kartu_pengawasan_tanggal_habis and $data->kartu_pengawasan_tanggal_terbit)
                    @php 
                    $terbit = date("Y-m-d", strtotime($data->kartu_pengawasan_tanggal_terbit));
                    $habis = date("Y-m-d", strtotime($data->kartu_pengawasan_tanggal_habis));
                    $batas = date("Y-m-d", strtotime("-2 month", strtotime($data->kartu_pengawasan_tanggal_habis)));
                    $hariIni = date("Y-m-d", strtotime("now"));
                    @endphp
                    @if( (($hariIni > $batas) and ($hariIni <= $habis)))
                        <i style="background-color: yellow; color: black;">Warning</i>
                    @elseif ($hariIni > $habis)
                        <i style="background-color: red; color: white;">Expired</i>
                    @elseif ($hariIni <= $batas)
                        <i style="background-color: green; color: white;">OK</i>
                    @endif
                @else
                    <i style="background-color: black; color: white;">Not Submittd</i>
                @endif
            </label>
            
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan" id="kartu_pengawasan" class="form-control" value="{{ (!empty($data))? $data->kartu_pengawasan_nomor : '' }}" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->kartu_pengawasan_tanggal_terbit : '' }}" class="form-control pull-right datepicker" id="kartu_pengawasan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan_tanggal_habis" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->kartu_pengawasan_tanggal_habis : '' }}" class="form-control pull-right datepicker" id="kartu_pengawasan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="kartu_pengawasan_file" class="form-control" >
                @if($data->kartu_pengawasan_file)
                    <a href="{{ route('backend::truckPermits_download', ['id' => $data->id_truck, 'lampiran' => 'kartu_pengawasan_file']) }}"><u>Download File Saat Ini</u></a><br>
                @endif
            </div>
            <div class="col-sm-2">
                <small>
                    <b>*Biarkan jika tidak akan diubah.</b>
                </small>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-md" name="simpan" value="Update">
                <a class="btn btn-primary" role="button" onclick="resetform()">Reset</a>
            </div>
        </div>
    </form>

@endsection

@push('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
    function resetform() {
        // document.getElementById("nomor_polisi").value = "";
        elements = [];
        elements = document.getElementsByClassName("form-control");
        for(var i=0; i<elements.length ; i++){
            elements[i].value = "" ;
        }
        
    }

    $(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true
        })
    })
    </script>
@endpush