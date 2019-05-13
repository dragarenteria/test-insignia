<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function viewPass(){
        return view('password');
    }

    public function index(){
        return view('usuario');
    }

    public function getUsers(){
        return [
            'data' => User::all()
        ];
    }

    public function editPass (Request $request){
        $success = '';
        
        DB::beginTransaction();
        try {

            //ditar la contraeña
            if (Hash::check(Input::get('pass_nueva'), Auth::user()->password)){
                User::where('id',Auth::id())->update([
                    'password' => Hash::make($request->pass_nueva),
                ]);

            }else {
               return [
                   'pass' => true
               ];
            }
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

    public function registro(Request $request){
        $validator = Validator::make($request->all(), [ //creamos la validación
            'name' => 'required', 
            'email' => 'required', 
            'email' => 'required|unique:users', 
        ]);
        if ($validator->fails()) {//validamos
            return response()->json(['error'=>$validator->errors()]);
        }

        $success = '';
        
        DB::beginTransaction();
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
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
    public function getReset(){
        return view('auth.passwords.reset');
    }

    public function editar(Request $request){
        $validator = Validator::make($request->all(), [ //creamos la validación
            'name' => 'required', 
            'email' => 'required|email|unique:users,email,'.$request->id,
        ]);
        if ($validator->fails()) {//validamos
            return response()->json(['error'=>$validator->errors()]);
        }

        $success = '';
        
        DB::beginTransaction();
        try {
            User::where('id',$request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
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

    public function eliminar($id){
       
        $success = '';
        
        DB::beginTransaction();
        try {
            User::where('id',$id)->delete();
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
