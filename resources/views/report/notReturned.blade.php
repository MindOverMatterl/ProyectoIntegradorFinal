@extends("layouts.app")
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <h2 class="admin-heading text-center">Reporte de Libros</h2>
                </div>
            </div>
            @if ($books->count() > 0)
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
                                <th>Fecha devolucion</th>
                                <th>Dias restantes</th>
                            </thead>
                            <tbody>
                                @forelse ($books as $index => $book)
                                    @php
                                        $date1 = date_create(date('Y-m-d'));
                                        $date2 = date_create($book->return_date->format('Y-m-d'));
                                        $diff = date_diff($date1, $date2);
                                        $overdueDays = $diff->format('%a');
                                    @endphp
                                    @if ($book->status !== 'Devuelto' && $overdueDays > 0 && !$book->is_returned_early)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $book->student->name }}</td>
                                            <td>{{ $book->book->name }}</td>
                                            <td>{{ $book->student->phone }}</td>
                                            <td>{{ $book->student->email }}</td>
                                            <td>{{ $book->issue_date->format('d M, Y') }}</td>
                                            <td>{{ $book->return_date->format('d M, Y') }}</td>
                                            <td>{{ $overdueDays }} days</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8">Ningun reporte encontrado!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <p>Ningun reporte encontrado!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
