<?php

namespace App\Http\Controllers\API;

use App\Film;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SakilaController extends Controller
{
    public function filmList()
    {
        $films = DB::table('film')->paginate(20);
        return $films;
    }

    public function film($id)
    {
        $film = Film::find($id);
        return $film;
    }

    public function search(Request $request)
    {
        $title = $request->query('title', null);
        $desc = $request->query('desc', null);
        $query = Film::query();
        if (!is_null($title)) {
            $query->where('title', 'LIKE', "%$title%");
        }
        if (!is_null($desc)) {
            $query->orWhere('description', 'LIKE', "%$desc%");
        }
        $films = $query->paginate(20);
        return $films;
    }

    public function insert(Request $request)
    {
        $film = new Film();
        $film->title = $request->title;
        $film->description = $request->desc;
        $film->release_year = $request->year;
        $film->save();
        return $film;
    }

    public function update(Request $request)
    {
        $film = Film::find($request->id);
        if ($film) {
            $film->title = $request->title;
            $film->description = $request->desc;
            $film->save();
            return $film;
        }
        return ['status' => 'failed', 'error' => 500, 'msg' => 'Record not found!'];
    }
}
