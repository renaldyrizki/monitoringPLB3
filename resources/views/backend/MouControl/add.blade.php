@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('mouControl_add') !!}
@endsection

@section('content')
    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('backend::mouControl_save') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <h3 style="text-align: center">Data Kontrak Kerjasama</h3>
        <div class="form-group">
            <label for="perusahaan_pengelola_lanjut" class="col-sm-2 control-label">Nama Perusahaan Lebih Lanjut</label>
            <div class="col-sm-6">
                <input required type="text" name="perusahaan_pengelola_lanjut" id="perusahaan_pengelola_lanjut" class="form-control" value="" placeholder="Nama Perusahaan Lebih Lanjut">
            </div>
        </div>
        <div class="form-group" row>
            <label for="status_kontrak" class="col-sm-2 control-label">Status Kontrak</label>
            <div class="col-sm-6">
                <select name="status_kontrak" class="form-control" required>
                    <option value=1>Masih Berlaku</option>
                    <option value=0>Sudah Tidak Berlaku</option>
                </select>
            </div>
        </div>
        <div class="form-group" row>
            <label for="tipe_pengelolaan" class="col-sm-2 control-label">Tipe Pengelolaan</label>
            <div class="col-sm-6">
                <select name="tipe_pengelolaan" class="form-control" required>
                    @foreach($tipe_pengelolaan as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group" row>
            <label for="jenis_limbah" class="col-sm-2 control-label">Jenis Limbah</label>
            <div class="col-sm-6">
                <label for="jenis_limbah">Mutiple select list (hold shift to select more than one):</label>
                <select name="jenis_limbah[]" multiple class="form-control" required>
                    @foreach($jenis_limbah as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="surat_pernyataan_tidak_masalah" class="col-sm-2 control-label">Surat Pernyataan Tidak Memiliki Masalah Lingkungan</label>
            <div class="col-sm-6">
                <input required type="file" accept="application/pdf" id="surat_pernyataan_tidak_masalah" name="surat_pernyataan_tidak_masalah" class="form-control">
                <small>
                    *File yang boleh diupload hanya file bertipe pdf.<br>
                    *Max size 2MB.
                </small>
            </div>
        </div>
        <h3 style="text-align: center">Perizinan Perusahaan Pengelola Lanjut</h3>
        <div class="form-group">
            <label for="nomor_izin_perusahaan" class="col-sm-2 control-label">No Izin</label>
            <div class="col-sm-6">
                <input required type="text" name="nomor_izin_perusahaan" id="nomor_izin_perusahaan" class="form-control" value="" placeholder="No Izin">
            </div>
        </div>
    
        <div class="form-group">
            <label for="tanggal_kontrak_perusahaan" class="col-sm-2 control-label">Tanggal Kontrak</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_kontrak_perusahaan" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_kontrak_perusahaan" placeholder="Tanggal Kontrak">
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_habis_berlaku_perusahaan" class="col-sm-2 control-label">Tanggal Habis Berlaku</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_habis_berlaku_perusahaan" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_habis_berlaku_perusahaan" placeholder="Tanggal Habis Berlaku">
            </div>
        </div>

        
        <div class="form-group">
            <label for="lampiran_perusahaan" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-6">
                <input required type="file" accept="application/pdf" id="lampiran_perusahaan" name="lampiran_perusahaan" class="form-control">
                <small>
                    *File yang boleh diupload hanya file bertipe pdf.<br>
                    *Max size 2MB.
                </small>
            </div>
        </div>

        <h3 style="text-align: center">Kontrak</h3>
        <div class="form-group">
            <label for="nomor_kontrak" class="col-sm-2 control-label">No Kontrak</label>
            <div class="col-sm-6">
                <input required type="text" name="nomor_kontrak" id="nomor_kontrak" class="form-control" value="" placeholder="No Kontrak">
            </div>
        </div>
    
        <div class="form-group">
            <label for="tanggal_terbit_kontrak" class="col-sm-2 control-label">Tanggal Terbit Kontrak</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_terbit_kontrak" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_terbit_kontrak" placeholder="Tanggal Terbit Kontrak">
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal_habis_berlaku_kontrak" class="col-sm-2 control-label">Tanggal Habis Berlaku</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_habis_berlaku_kontrak" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_habis_berlaku_kontrak" placeholder="Tanggal Habis Berlaku">
            </div>
        </div>

        <div class="form-group">
            <label for="lampiran_kontrak" class="col-sm-2 control-label">Lampiran</label>
            <div class="col-sm-6">
                <input required type="file" accept="application/pdf" id="lampiran_kontrak" name="lampiran_kontrak" class="form-control">
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
        $(document).ready(function(){
            $("input[type=file]").change(function(){
                if (this.files[0].size > 2097152) {
                    this.value = "";
                };
            });
        });
    </script>
    <script>
    function resetform() {
        // document.getElementById("nomor_polisi").value = "";
        elements = [];
        elements = document.getElementsByClassName("form-control");
        for(var i=0; i<elements.length ; i++){
            console.log(elements[i].name);
            if (elements[i].name == 'status_kontrak' || elements[i].name == 'tipe_pengelolaan' || elements[i].name == 'jenis_limbah'){
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