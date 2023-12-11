@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Escritores</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('authors.create') }}">Agregar Escritor</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>#</th>
                            <th>Nombre del Escritor</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @forelse ($authors as $author)
                                <tr>
                                    <td>{{ ($authors->currentPage() - 1) * $authors->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $author->name }}</td>
                                    <td class="edit">
                                        <a href="{{ route('authors.edit', $author) }}" class="btn btn-success">Editar</a>
                                    </td>
                                    <td class="delete">
                                        <form action="{{ route('authors.destroy', $author->id) }}" method="post"
                                            class="form-hidden">
                                            <button class="btn btn-danger delete-author">Eliminar</button>
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No se encontraron Escritores</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $authors->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
