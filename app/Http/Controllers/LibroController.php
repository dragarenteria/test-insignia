<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('libro');
    }

    public function getLibros(){
        return [
            'data'=>Libro::where('user_id',Auth::id())->get()
        ];
    }
    public function setLibro(Request $request){
        $success = '';

        DB::beginTransaction();
        try {
           Libro::create([
            'nombre_libro' => $request->nombre,
            'autor' => $request->autor,
            'genero' => $request->genero,
            'num_paginas' => $request->paginas,
            'user_id' => Auth::id(),
           ]);
            DB::commit();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;

            DB::rollBack();
            $error = $th->getMessage();

        }

        if ($success) {
            return ['status' => true];
        }else{
            return ['status' => false, 'error' => $error];
        }
    }

    public function putLibro(Request $request){
        $success = '';

        DB::beginTransaction();
        try {
           Libro::where('user_id',Auth::id())->where('id',$request->id)->update([
            'nombre_libro' => $request->nombre_libro,
            'autor' => $request->autor,
            'genero' => $request->genero,
            'num_paginas' => $request->num_paginas,
            // 'estado' => $request->estado,
           ]);
            DB::commit();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;

            DB::rollBack();
            $error = $th->getMessage();

        }

        if ($success) {
            return ['status' => true];
        }else{
            return ['status' => false, 'error' => $error];
        }
    }

    public function deleteLibro($id){
        $success = '';
        DB::beginTransaction();
        try {
           Libro::where('user_id',Auth::id())->where('id',$id)->delete();
            DB::commit();
            $success = true;
        } catch (\Throwable $th) {
            $success = false;

            DB::rollBack();
            $error = $th->getMessage();

        }

        if ($success) {
            return ['status' => true];
        }else{
            return ['status' => false, 'error' => $error];
        }

    }
}
