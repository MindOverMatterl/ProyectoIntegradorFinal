@extends('layouts.app')

@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="admin-heading">Ajustes</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <form class="your-form" action="{{ route('settings') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="return_days">Días de Devolución</label>
                            <input type="number" class="form-control" id="return_days" name="return_days" value="{{ $data ? $data->return_days : old('return_days') }}" required>
                            @error('return_days')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="fine">Mora en S/</label>
                            <input type="number" class="form-control" id="fine" name="fine" value="{{ $data ? $data->fine : old('fine') }}" required>
                            @error('fine')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Ajustes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
