@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Prestamos</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    <a class="add-new" href="{{ route('book_issue.create') }}">Agregar prestamo</a>
                </div>
            </div>
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
                            <th>Fecha de </th>
                            <th>Estatus</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @forelse ($books as $index => $book)
                                <tr @if (date("Y-m-d") > $book->return_date->format("Y-m-d") && $book->issue_status == "N") style="background:rgba(255,0,0,0.2)" @endif>
                                    <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $book->student?->name }}</td>
                                    <td>{{ $book->book?->name }}</td>
                                    <td>{{ $book->student?->phone }}</td>
                                    <td>{{ $book->student?->email }}</td>
                                    <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                    <td>{{ $book->return_date->format('d M, Y') }}</td>
                                    <td>
                                        @if ($book->issue_status == 'Y')
                                            <span class='badge badge-success'>Devuelto</span>
                                        @else
                                            <span class='badge badge-danger'>No devuelto</span>
                                        @endif
                                    </td>
                                    <td class="edit">
                                        <a href="{{ route('book_issue.edit', $book->id) }}" class="btn btn-success">Editar</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('book_issue.destroy', $book) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger">Eliminar</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">Ningun problema con Libros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $books->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
