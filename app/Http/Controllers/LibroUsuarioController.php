<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libro;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Libro_usuario;
use Illuminate\Support\Facades\DB;

class LibroUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        
        return view('prestar_libro', );
    }
    public function datosSelect(){
        $libros = Libro::where('user_id',Auth::id())->where('estado',Libro::DISPONIBLE)->get();
        $usuarios = User::where('id', '!=', Auth::id())->get();
        return ['libros' => $libros,'users' => $usuarios];
    }
    public function getPrestamo(){
        return [
            'data' => Libro_usuario::with(['users','libros'])->get()
        ];
    }
    public function setPrestamo(Request $request){
        $success = '';
        DB::beginTransaction();
        try {
            Libro_usuario::create([
            'user_id' => $request->user,
            'libro_id' => $request->libro,
           ]);

           Libro::where('id',$request->libro)->update([
                'estado' => Libro::PRESTADO
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
    public function putPrestamo(Request $request){
        DB::beginTransaction();
        try {
            Libro_usuario::where('id',$request->id)->update([
                'estado' => Libro::DISPONIBLE
           ]);

           Libro::where('id',$request->libros['id'])->update([
                'estado' => Libro::DISPONIBLE
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
}
