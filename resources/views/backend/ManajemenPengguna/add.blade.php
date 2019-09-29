@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('manajemenPengguna_add') !!}
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="icon fa fa-check"></i> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Perhatian</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('backend::manajemenPengguna_save') }}" class="form-horizontal" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-6">
                <input required type="text" name="name" id="name" class="form-control" value="" placeholder="Nama Pengguna">
            </div>
        </div>
        
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-6">
                <input required type="email" name="email" id="email" class="form-control" value="" placeholder="example@domain.com">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-6">
                <input required type="password" name="password" id="password" class="form-control" value="" placeholder="password">
            </div>
        </div>

        <div class="form-group" row>
            <label for="isAdmin" class="col-sm-2 control-label">Role</label>
            <div class="col-sm-6">
                <select name="isAdmin" class="form-control" required>
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
        </div>

        <div class="form-group" row>
            <label for="plant_id" class="col-sm-2 control-label">Plant</label>
            <div class="col-sm-6">
                <select name="plant_id" class="form-control" required>
                    @foreach($plant as $key => $value)
                        <option value={{$key}}>{{ $value }}</option>
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