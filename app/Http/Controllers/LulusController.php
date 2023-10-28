<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class LulusController extends Controller
{
    public function index()
    {
        if (!isset($_GET['nisn'])) {
            return view('lulus.search-nisn');
        } else {
            $result = DB::table('status_siswa')
                ->where('nisn', '=', $_GET['nisn'])
                ->get();

            return view('lulus.keterangan', ['siswas' => $result]);
        }
    }
}
