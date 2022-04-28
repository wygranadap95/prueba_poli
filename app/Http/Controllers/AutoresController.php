<?php

namespace App\Http\Controllers;

use App\Models\autores;
use Illuminate\Http\Request;

class AutoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultsT = \DB::select('SELECT 
                                        id,nombre,apellido,identificacion
                                FROM autores');
        $arregloT = json_decode(json_encode($resultsT), true);
        return view('autores.index', compact('arregloT'));
    }

    public function store(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        $nombre = $datosAC['nombre'];
        $apellido = $datosAC['apellido'];
        $identificacion = $datosAC['identificacion'];
        if ($id == 0) {

            $resultsVA = \DB::select("SELECT 
                                        id,nombre,apellido,identificacion
                                FROM autores
                                WHERE identificacion = '$identificacion'
                                 ");
            $tuplas = count($resultsVA);
            if ($tuplas > 0) {
                return response()->json('repetido');
            } else {
                \DB::insert("INSERT INTO  autores (identificacion,nombre,apellido) VALUES('$identificacion','$nombre','$apellido') ");
                $method = 'ok';
                return response()->json($method);
            }
        } else {
            \DB::update("UPDATE autores SET nombre='$nombre',apellido='$apellido' WHERE id = '$id' ");
            $method = 'upd';
            return response()->json($method);
        }
    }
    public function delete(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        \DB::delete("DELETE FROM autores WHERE id ='$id' ");
        $method = 'ok';
        return response()->json($method);
    }
    public function update(Request $request)
    {
        $datosAC = request()->except(['_token', '_method']);
        $id = $datosAC['id'];
        $rsp = \DB::select("SELECT nombre,apellido,id,identificacion FROM autores WHERE id ='$id' ");
        $array_rsp = json_decode(json_encode($rsp), true);
        return response()->json($array_rsp);
    }
}
