@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('penyimpananLimbahB3_add') !!}
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
    <form action="{{ route('backend::penyimpananLimbahB3_save') }}" class="form-horizontal" method="post">
        {{ csrf_field() }}
        <div class="form-group" row>
            <label for="jenis_limbah" class="col-sm-2 control-label">Jenis Limbah</label>
            <div class="col-sm-6">
                <select name="jenis_limbah" class="form-control" required>
                    @foreach($jenis_limbah as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    
        <div class="form-group">
            <label for="tanggal_penyimpanan" class="col-sm-2 control-label">Tanggal Penyimpanan</label>
            <div class="col-sm-6">
                <input required type="text" name="tanggal_penyimpanan" data-date-format='yyyy-mm-dd' value="" class="form-control pull-right datepicker" id="tanggal_penyimpanan" placeholder="Tanggal Penyimpanan">
            </div>
        </div>

        <div class="form-group">
            <label for="masa_simpan" class="col-sm-2 control-label">Masa Simpan (Hari)</label>
            <div class="col-sm-6">
                <input required type="number" min=1 name="masa_simpan" id="masa_simpan" class="form-control" value="" placeholder="Masa Simpan Dalam Hari">
            </div>
        </div>

        <div class="form-group">
            <label for="sumber_limbah" class="col-sm-2 control-label">Sumber Limbah</label>
            <div class="col-sm-6">
                <input required type="text" name="sumber_limbah" id="sumber_limbah" class="form-control" value="" placeholder="Sumber Limbah">
            </div>
        </div>
        
        <div class="form-group">
            <label for="total_penyimpanan" class="col-sm-2 control-label">Total yang Disimpan</label>
            <div class="col-sm-4">
                <input required type="number" min=0 name="total_penyimpanan" id="total_penyimpanan" class="form-control" value="" placeholder="Berat dalam satuan KG">
            </div>
            <div class="col-sm-2">
                <select name="satuan" class="form-control" required>
                    @foreach($satuan as $sat)
                        <option value={{ $sat }} >{{ $sat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-md" name="simpan" value="Simpan">
                {{-- <input class="btn btn-primary btn-md" name="reset" value="" onclick="reset()"> --}}
                {{-- <button class="btn btn-primary btn-md" onclick="reset()">Click me</button> --}}
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
            console.log(elements[i].name);
            if (elements[i].name == 'jenis_limbah' || elements[i].name == 'satuan'){
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