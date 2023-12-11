<?php

namespace App\Http\Controllers;

use App\Models\book_issue;
use App\Http\Requests\Storebook_issueRequest;
use App\Http\Requests\Updatebook_issueRequest;
use App\Models\auther;
use App\Models\book;
use App\Models\settings;
use App\Models\student;
use \Illuminate\Http\Request;

class BookIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.issueBooks', [
            'books' => book_issue::Paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.issueBook_add', [
            'students' => student::latest()->get(),
            'books' => book::where('status', 'Y')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storebook_issueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storebook_issueRequest $request)
{
    // Obtener el último registro de settings
    $settings = settings::latest()->first();

    // Verificar si $settings no es null antes de acceder a return_days
    if ($settings) {
        $return_days = $settings->return_days;
    } else {
        // Manejar el caso en que $settings es null
        // Puedes asignar un valor predeterminado o lanzar una excepción, según tus necesidades.
        $return_days = 0; // Asignar un valor predeterminado de 0
        // Alternativamente, puedes lanzar una excepción para indicar que los ajustes no están disponibles.
        // throw new \RuntimeException('No se encontraron ajustes disponibles.');
    }

    $issue_date = date('Y-m-d');
    $return_date = date('Y-m-d', strtotime("+" . $return_days . " days"));

    $data = book_issue::create($request->validated() + [
        'student_id' => $request->student_id,
        'book_id' => $request->book_id,
        'issue_date' => $issue_date,
        'return_date' => $return_date,
        'issue_status' => 'N',
    ]);

    $data->save();

    $book = book::find($request->book_id);

    $book->status = 'N';

    $book->save();

    return redirect()->route('book_issued');
}

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    // Obtener el último registro de settings
    $settings = settings::latest()->first();

    // Verificar si $settings no es null antes de acceder a fine
    if ($settings) {
        $fine = $settings->fine;
    } else {
        // Manejar el caso en que $settings es null
        // Puedes asignar un valor predeterminado o lanzar una excepción, según tus necesidades.
        $fine = 0; // Asignar un valor predeterminado de 0
        // Alternativamente, puedes lanzar una excepción para indicar que los ajustes no están disponibles.
        // throw new \RuntimeException('No se encontraron ajustes disponibles.');
    }

    $book = book_issue::findOrFail($id);
    $first_date = date_create(date('Y-m-d'));
    $last_date = date_create($book->return_date);
    $diff = date_diff($first_date, $last_date);
    $fine_total = $fine * $diff->format('%a');

    return view('book.issueBook_edit', [
        'book' => $book,
        'fine' => $fine_total,
    ]);
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatebook_issueRequest  $request
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $book = book_issue::find($id);
        $book->issue_status = 'Y';
        $book->return_day = now();
        $book->save();
        $bookk = book::find($book->book_id);
        $bookk->status= 'Y';
        $bookk->save();
        return redirect()->route('book_issued');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\book_issue  $book_issue
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        book_issue::find($id)->delete();
        return redirect()->route('book_issued');
    }
}
