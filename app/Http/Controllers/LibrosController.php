<?php

namespace App\Http\Controllers;

use App\Models\libros;
use Illuminate\Http\Request;

class LibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultsA = \DB::select('SELECT 
                                        id,nombre,apellido
                                FROM autores');
        $arregloA = json_decode(json_encode($resultsA), true);

        $resultsT = \DB::select('SELECT 
                                        t2.id,t1.nombre,t2.nombre as nomb_libro,t1.apellido
                                FROM autores t1  inner join libros t2   ON t1.id = t2.id_autor  ');
        $arregloT = json_decode(json_encode($resultsT), true);
        return view('libros.index', compact('arregloA', 'arregloT'));
    }

    public function store(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        $nombre = $datosAC['nombre'];
        $id_autor = $datosAC['id_autor'];

        if ($id == 0) {
            \DB::insert("INSERT INTO  libros (nombre,id_autor) VALUES('$nombre','$id_autor') ");
            $method = 'ok';
            return response()->json($method);
        } else {
            \DB::update("UPDATE libros SET nombre='$nombre',id_autor='$id_autor' WHERE id = '$id' ");
            $method = 'upd';
            return response()->json($method);
        }
    }
    public function delete(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        \DB::delete("DELETE FROM libros WHERE id ='$id' ");
        $method = 'ok';
        return response()->json($method);
    }
    public function update(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        $rsp = \DB::select("SELECT id,nombre,id_autor FROM libros WHERE id ='$id' ");
        $array_rsp = json_decode(json_encode($rsp), true);
        return response()->json($array_rsp);
    }
}
