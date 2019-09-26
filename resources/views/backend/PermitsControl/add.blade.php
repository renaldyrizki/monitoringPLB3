@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('permitsControl_add') !!}
@endsection

@section('content')
    <form action="{{ route('backend::permitsControl_save') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group" row>
            <label for="jenis_perizinan" class="col-sm-2 control-label">Jenis Perizinan</label>
            <div class="col-sm-6">
                <select name="jenis_perizinan" class="form-control" required>
                    @foreach($jenis_perizinan as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="nama_perusahaan" class="col-sm-2 control-label">Nama Perusahaan</label>
            <div class="col-sm-6">
                <input required type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control" value="" placeholder="Nama Perusahaan">
            </div>
        </div>

        <div class="form-group" row>
            <label for="status_izin" class="col-sm-2 control-label">Status Izin</label>
            <div class="col-sm-6">
                <select name="status_izin" class="form-control" required>
                    <option value=1>Aktif</option>
                    <option value=0>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="form-group" row>
            <label for="dikeluarkan_oleh" class="col-sm-2 control-label">Dikeluarkan Oleh</label>
            <div class="col-sm-6">
                <select name="dikeluarkan_oleh" class="form-control" required>
                    @foreach($dikeluarkan_oleh as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="no_surat_keputusan" class="col-sm-2 control-label">No Surat Keputusan</label>
            <div class="col-sm-6">
                <input required type="text" name="no_surat_keputusan" id="no_surat_keputusan" class="form-control" value="" placeholder="No Surat Keputusan">
            </div>
        </div>
    
        <div class="form-group">
            <label for="tanggal_terbit_izin" class="col-sm-2 control-label">Tanggal Terbit Izin</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_terbit_izin" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_terbit_izin" placeholder="Tanggal Terbit Izin">
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_habis_izin" class="col-sm-2 control-label">Tanggal Habis Izin</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_habis_izin" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_habis_izin" placeholder="Tanggal Habis Izin">
            </div>
        </div>

        <div class="form-group">
            <label for="lampiran_dokumen" class="col-sm-2 control-label">Lampiran Dokumen</label>
            <div class="col-sm-6">
                <input required type="file" accept="application/pdf" id="lampiran_dokumen" name="lampiran_dokumen" class="form-control">
                <small>
                    *File yang boleh diupload hanya file bertipe pdf.<br>
                    *Max size 2MB.
                </small>
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
        $(document).ready(function () {
    
            var uploadField = document.getElementById("lampiran_dokumen");
    
            uploadField.onchange = function () {
                if (this.files[0].size > 2097152) {
                    this.value = "";
                };
            };
        });
    </script>
    <script>
    function resetform() {
        // document.getElementById("nomor_polisi").value = "";
        elements = [];
        elements = document.getElementsByClassName("form-control");
        for(var i=0; i<elements.length ; i++){
            console.log(elements[i].name);
            if (elements[i].name == 'jenis_perizinan' || elements[i].name == 'status_izin' || elements[i].name == 'dikeluarkan_oleh'){
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