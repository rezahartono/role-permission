<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class DataTable
{
    public $data, $pathView, $pathEdit, $pathDelete;

    public function __construct($data, $pathView, $pathEdit, $pathDelete)
    {
        $this->data = $data;
        $this->pathView = $pathView;
        $this->pathEdit = $pathEdit;
        $this->pathDelete = $pathView;
    }

    public function generate()
    {
        return DataTables::of($this->data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btnView = '<a href="' . $this->pathView  . '/' . $row->id . '" class="btn btn-info btn-sm mx-1"><i class="fas fa-eye"></i></a>';
                $btnEdit = '<a href="' . $this->pathEdit  . '/' . $row->id . '" class="btn btn-primary btn-sm mx-1"><i class="fas fa-edit"></i></a>';
                $btnDelete = '<a href="' . $this->pathDelete  . '/' . $row->id . '" class="btn btn-danger btn-sm mx-1"><i class="fas fa-trash"></i></a>';
                return $btnView . $btnEdit . $btnDelete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
