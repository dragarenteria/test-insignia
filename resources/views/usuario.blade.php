@extends('layouts.app')

@section('content')
<div class="container" id="main_usuario">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center"><button data-toggle="modal" data-target="#nuevo_usuario" class="btn btn-primary"><i
                    class="fas fa-plus"></i> Nuevo usuario</button></div>

                    <div class="card-body table-responsive">

                        <table class="table table-striped text-center" id="tabla_usuario">
                            <thead>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Correo electronico</th>
                                <th>Fecha de creación</th>
                                <th>Ultima modificacion</th>
                                {{-- <th>Opciones</th> --}}
                            </thead>
    
                        </table>
    
                    </div>
            </div>
        </div>
    </div>

    {{-- modal nuevo usuario --}}
    <form @submit.prevent="crearUsuario()" class="modal fade" id="nuevo_usuario" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Nuevo usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nombre<span class="text-danger">*</span></label>
                            <input v-model="usuario.name" type="text" required class="form-control"
                                placeholder="Nombre">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Correo electronico <span class="text-danger">*</span></label>
                            <input v-model="usuario.email" type="email" required class="form-control"
                                placeholder="Correo electronico">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Contraseña <span class="text-danger">*</span></label>
                            <input v-model="usuario.password" type="password" required class="form-control"
                                placeholder="Contraseña">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Confirmar contraseña <span class="text-danger">*</span></label>
                            <input v-model="usuario.c_password" type="password" required class="form-control"
                                placeholder="Confirmar contraseña ">
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/usuario_admin.js') }}"></script>
@endsection