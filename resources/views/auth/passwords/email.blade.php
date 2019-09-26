@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

            
            <div class="card">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                    <div class="card-block">
                        <h3 class="card-title">Request Password</h3>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                    </div>
                    <div class="card-footer">
                        
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
