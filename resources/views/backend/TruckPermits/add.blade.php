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
    <form action="{{ route('backend::truckPermits_save') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
        <div class="form-group" row>
            <label for="jenis_kendaraan" class="col-sm-2 control-label">Jenis Kendaraan</label>
            <div class="col-sm-6">
                <select name="jenis_kendaraan" class="form-control" required>
                    <option value=1>Terbuka</option>
                    <option value=0>Tertutup</option>
                </select>
            </div>
        </div>
    
        <div class="form-group">
            <label for="no_polisi" class="col-sm-2 control-label">Nomor Polisi</label>
            <div class="col-sm-6">
                <input required type="text" maxlength="8" name="no_polisi" id="no_polisi" class="form-control" value="" placeholder="Nomor Polisi">
            </div>
        </div>

        <div class="form-group">
            <label for="perusahaan_transporter" class="col-sm-2 control-label">Perusahaan Transporter</label>
            <div class="col-sm-6">
                <input required type="text" name="perusahaan_transporter" id="perusahaan_transporter" class="form-control" value="" placeholder="Perusahaan Transporter">
            </div>
        </div>

        <div class="form-group" row>
            <label for="jk_limbah" class="col-sm-2 control-label">Jenis dan Kode Limbah</label>
            <div class="col-sm-6">
                <label for="jk_limbah">Mutiple select list (hold shift to select more than one):</label>
                <select name="jk_limbah[]" multiple class="form-control" required>
                    @foreach($jk_limbah as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="berat_maksimum_kendaraan" class="col-sm-2 control-label">Berat Maksimum Kendaraan</label>
            <div class="col-sm-6">
                <input required type="number" min=1 name="berat_maksimum_kendaraan" id="berat_maksimum_kendaraan" class="form-control" value="" placeholder="Berat dalam satuan KG">
            </div>
        </div>

        <div class="form-group">
            <label for="berat_limbah_dapat_diangkut" class="col-sm-2 control-label">Berat Limbah Dapat Diangkut</label>
            <div class="col-sm-6">
                <input required type="number" min=1 name="berat_limbah_dapat_diangkut" id="berat_limbah_dapat_diangkut" class="form-control" value="" placeholder="Berat dalam satuan KG">
            </div>
        </div>

        <h3 style="text-align: center">Lampiran</h3>

        <div class="form-group">
            <label for="izin_pengangkutan" class="col-sm-2 control-label">Izin Pengangkutan</label>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan" id="izin_pengangkutan" class="form-control" value="" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="izin_pengangkutan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="izin_pengangkutan_tanggal_habis" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="izin_pengangkutan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="izin_pengangkutan_file" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="dokumen_lingkungan" class="col-sm-2 control-label">Dokumen Lingkungan</label>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan" id="dokumen_lingkungan" class="form-control" value="" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="dokumen_lingkungan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="dokumen_lingkungan_tanggal_habis" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="dokumen_lingkungan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="dokumen_lingkungan_file" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="mou" class="col-sm-2 control-label">MOU</label>
            <div class="col-sm-2">
                <input type="text" name="mou" id="mou" class="form-control" value="" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="mou_tanggal_terbit" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="mou_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="mou_tanggal_habis" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="mou_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="mou_file" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="kartu_pengawasan" class="col-sm-2 control-label">Kartu Pengawasan</label>
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan" id="kartu_pengawasan" class="form-control" value="" placeholder="Nomor">
            </div>
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan_tanggal_terbit" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="kartu_pengawasan_tanggal_terbit" placeholder="Tanggal terbit">
            </div>
            <div class="col-sm-2">
                <input type="text" name="kartu_pengawasan_tanggal_habis" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="kartu_pengawasan_tanggal_habis" placeholder="Tanggal Habis Berlaku">
            </div>
            <div class="col-sm-2">
                <input type="file" accept="application/pdf" name="kartu_pengawasan_file" class="form-control" >
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-md" name="simpan" value="Simpan">
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
    <script type="text/javascript">
        $(document).ready(function(){
            // $("input[type=file]").click(function(){
            //     $(this).val("");
            // //     $(this).val("");
            // });

            $("input[type=file]").change(function(){
                // alert($(this).val());
                if (this.files[0].size > 2097152) {
                    this.value = "";
                    // alert("File tidak boleh lebih dari 2mb");
                };
                // alert(this.files[0].size);
            });
        });
    </script>
    <script>
    function resetform() {
        // document.getElementById("nomor_polisi").value = "";
        elements = [];
        elements = document.getElementsByClassName("form-control");
        for(var i=0; i<elements.length ; i++){
            if (elements[i].name == 'kategori'){
                elements[i].selectedIndex = 0 ;
            }else{
                elements[i].value = "" ;
            }
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