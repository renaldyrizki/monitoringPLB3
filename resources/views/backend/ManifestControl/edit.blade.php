@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('pengangkutanLimbahB3') !!}
@endsection

@section('content')
    {{-- Welcome {{ Auth::user()->name }} --}}
    {{-- <h3>Tambah Truck</h3> --}}
    {{-- <hr style="border-top-color: black"> --}}

<form action="{{ route('backend::manifestControl_update', ['id' => $data->id_pengangkutan]) }}" class="form-horizontal" method="post">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PATCH">
    {{-- {{ method_field('PATCH') }} --}}
        <div class="form-group" row>
            <label for="jenis_limbah" class="col-sm-2 control-label">Jenis Limbah</label>
            <div class="col-sm-6">
                <select name="jenis_limbah" class="form-control" disabled>
                    @foreach($jenis_limbah as $key => $value)
                        <option value={{$key}} {{ (!empty($data))? ($data->jenis_limbah==$value) ? ' selected' : '' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group" row>
            <label for="status_pengangkutan" class="col-sm-2 control-label">Status Pengangkutan</label>
            <div class="col-sm-6">
                <select name="status_pengangkutan" class="form-control">
                    <option value="Diterima" {{ (!empty($data))? ($data->status_pengangkutan=="True") ? ' selected' : '' : '' }}>Diterima</option>
                    <option value="Belum Diterima" {{ (!empty($data))? ($data->status_pengangkutan=="False") ? ' selected' : '' : '' }}>Belum Diterima</option>
                </select>
                {{-- <input readonly disabled type="text" name="status_pengangkutan" value="{{ (!empty($data))? ($data->status_pengangkutan==1)? 'Diterima' : 'Belum Diterima' : '' }}" class="form-control" id="status_pengangkutan" placeholder="Status Pengangkutan"> --}}
            </div>
        </div>
    
        <div class="form-group">
            <label for="tanggal_pengangkutan" class="col-sm-2 control-label">Tanggal Pengangkutan</label>
            <div class="col-sm-6">
                <input disabled type="text" name="tanggal_pengangkutan" data-date-format='yyyy-mm-dd' value="{{ (!empty($data))? $data->tanggal_pengangkutan : '' }}" class="form-control pull-right datepicker" id="tanggal_pengangkutan" placeholder="Tanggal Pengangkutan">
            </div>
        </div>

        <div class="form-group">
            <label for="total_pengangkutan" class="col-sm-2 control-label">Total Pengangkutan</label>
            <div class="col-sm-4">
                <input disabled type="number" min=0 name="total_pengangkutan" id="total_pengangkutan" class="form-control" value="{{ (!empty($data))? $data->total_pengangkutan : '' }}" placeholder="Total Pengangkutan">
            </div>
            <div class="col-sm-2">
                <select name="satuan" class="form-control" disabled>
                    @foreach($satuan as $sat)
                        <option value={{ $sat }} >{{ $sat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="nomor_manifest" class="col-sm-2 control-label">Nomor Manifest</label>
            <div class="col-sm-6">
                <input disabled type="text" name="nomor_manifest" id="nomor_manifest" class="form-control" value="{{ (!empty($data))? $data->nomor_manifest : '' }}" placeholder="Nomor Manifest">
            </div>
        </div>

        <div class="form-group">
            <label for="perusahaan_pengangkut" class="col-sm-2 control-label">Perusahaan Pengangkutan</label>
            <div class="col-sm-6">
                <input disabled type="text" name="perusahaan_pengangkut" id="perusahaan_pengangkut" class="form-control" value="{{ (!empty($data))? $data->perusahaan_pengangkut : '' }}" placeholder="Perusahaan Pengangkut">
            </div>
        </div>

        <div class="form-group">
            <label for="tujuan_pemanfaatan" class="col-sm-2 control-label">Tujuan Pemanfaatan</label>
            <div class="col-sm-6">
                <input disabled type="text" name="tujuan_pemanfaatan" id="tujuan_pemanfaatan" class="form-control" value="{{ (!empty($data))? $data->tujuan_pemanfaatan : '' }}" placeholder="Tujuan Pemanfaatan">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-success btn-md" name="simpan" value="Update">
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