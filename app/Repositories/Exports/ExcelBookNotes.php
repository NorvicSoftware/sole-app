<?php

namespace App\Repositories\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelBookNotes implements FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('books.notes.excel', [
            'data' => $this->data
        ]);
    }
}
