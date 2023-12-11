@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <h2 class="admin-heading text-center">Reportes de prestamos por Fecha</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-4">
                    <form class="yourform mb-5" action="{{ route('reports.date_wise_generate') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                            @error('date')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="submit" class="btn btn-danger" name="search_date" value="Buscar">
                    </form>
                </div>
            </div>
            @if ($books)
                <div class="row">
                    <div class="col-md-12">
                        <table class="content-table">
                            <thead>
                                <th>#</th>
                                <th>Nombre del Estudiante</th>
                                <th>Nombre del Libro</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Fecha del Prestamo</th>
                            </thead>
                            <tbody>
                                @forelse ($books as $index => $book)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $book->student->name }}</td>
                                        <td>{{ $book->book->name }}</td>
                                        <td>{{ $book->student->phone }}</td>
                                        <td>{{ $book->student->email }}</td>
                                        <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Ningun registro encontrado</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection