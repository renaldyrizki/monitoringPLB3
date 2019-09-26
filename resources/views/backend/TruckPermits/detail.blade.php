@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('dataTruck') !!}
@endsection

@section('content')
    {{-- Welcome {{ Auth::user()->name }} --}}
    {{-- <h3>Tambah Truck</h3> --}}
    {{-- <hr style="border-top-color: black"> --}}
    {{ csrf_field() }}
    <form class="form-horizontal">
        <div class="form-group" row>
            <label for="jenis_kendaraan" class="col-sm-3 control-label">Jenis Kendaraan</label>
            <label for="jenis_kendaraan" class="col-sm-6 control-label" style="text-align: left"> : Bak Tertutup</label>
        </div>
    
        <div class="form-group">
            <label for="nomor_polisi" class="col-sm-3 control-label">Nomor Polisi</label>
            <label for="nomor_polisi" class="col-sm-6 control-label" style="text-align: left"> : T 1234 AF</label>
        </div>

        <div class="form-group">
            <label for="perusahaan_transporter" class="col-sm-3 control-label">Perusahaan Transporter</label>
            <label for="perusahaan_transporter" class="col-sm-6 control-label" style="text-align: left"> : PT Ciwaruga</label>
        </div>

        <div class="form-group">
            <label for="JK_limbah" class="col-sm-3 control-label">Jenis dan Kode Limbah</label>
            <label for="JK_limbah" class="col-sm-6 control-label" style="text-align: left"> : Besi Aluminium</label>
        </div>

        <div class="form-group">
            <label for="berat_kendaraan" class="col-sm-3 control-label">Berat Max Kendaraan</label>
            <label for="berat_kendaraan" class="col-sm-6 control-label" style="text-align: left"> : 21000 KG</label>
        </div>

        <div class="form-group">
            <label for="berat_limbah" class="col-sm-3 control-label" style="text-align: right">Berat Limbah Dapat Diangkut</label>
            <label for="berat_limbah" class="col-sm-6 control-label" style="text-align: left"> : 21000 KG</label>
        </div>

        <h3 style="text-align: center">Lampiran</h3>

        <div class="form-group">
            <label for="izin_pengangkutan" class="col-sm-3 control-label">Izin Pengangkutan</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">: XXX/XXX/XXX</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <a href="#" class="col-sm-2 control-label" style="text-align: left"><u>Lampiran</u></a>
            {{-- <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">Lampiran</label> --}}
        </div>

        <div class="form-group">
            <label for="dokumen_lingkungan" class="col-sm-3 control-label">Dokumen Lingkungan</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">: XXX/XXX/XXX</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <a href="#" class="col-sm-2 control-label" style="text-align: left"><u>Lampiran</u></a>
        </div>
        <div class="form-group">
            <label for="mou" class="col-sm-3 control-label">MOU</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">: XXX/XXX/XXX</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <a href="#" class="col-sm-2 control-label" style="text-align: left"><u>Lampiran</u></a>
        </div>
        <div class="form-group">
            <label for="kartu_pengawasan" class="col-sm-3 control-label">Kartu Pengawasan</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">: XXX/XXX/XXX</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <label for="izin_pengangkutan" class="col-sm-2 control-label" style="text-align: left">12-02-2019</label>
            <a href="#" class="col-sm-2 control-label" style="text-align: left"><u>Lampiran</u></a>
        </div>
        
        {{-- <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-md" name="simpan" value="Kembali">
            </div>
        </div> --}}
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