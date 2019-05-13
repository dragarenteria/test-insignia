@extends('layouts.app')

@section('content')
<div class="container" id="main_libro">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">
                        <button data-toggle="modal" data-target="#nuevo_libro" class="btn btn-primary"><i
                                class="fas fa-plus"></i> Nuevo libro</button>
                    </h3>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-striped text-center" id="tabla_libro">
                        <thead>
                            <th>#</th>
                            <th>Autor</th>
                            <th>Nombre del libro</th>
                            <th>Genero</th>
                            <th>Numero de paginas</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </thead>

                    </table>

                </div>
            </div>
        </div>
    </div>

    {{-- modal nuevo libro --}}
    <form @submit.prevent="crearLibro" class="modal fade" id="nuevo_libro" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Nuevo libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nombre del libro <span class="text-danger">*</span></label>
                            <input v-model="nuevoLibro.nombre" type="text" required class="form-control"
                                placeholder="Nombre del libro">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Autor <span class="text-danger">*</span></label>
                            <input v-model="nuevoLibro.autor" type="text" required class="form-control"
                                placeholder="Autor">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Género <span class="text-danger">*</span></label>
                            <input v-model="nuevoLibro.genero" type="text" required class="form-control"
                                placeholder="Género">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Numero de páginas <span class="text-danger">*</span></label>
                            <input v-model="nuevoLibro.paginas" type="number" required class="form-control"
                                placeholder="Numero de páginas">
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

    {{-- modal Editar libro --}}
    <form @submit.prevent="editarLibro" class="modal fade" id="editar_libro" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Editar libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Nombre del libro <span class="text-danger">*</span></label>
                            <input v-model="editLibro.nombre_libro" type="text" required class="form-control"
                                placeholder="Nombre del libro">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Autor <span class="text-danger">*</span></label>
                            <input v-model="editLibro.autor" type="text" required class="form-control"
                                placeholder="Autor">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Género <span class="text-danger">*</span></label>
                            <input v-model="editLibro.genero" type="text" required class="form-control"
                                placeholder="Género">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Numero de páginas <span class="text-danger">*</span></label>
                            <input v-model="editLibro.num_paginas" type="number" required class="form-control"
                                placeholder="Numero de páginas">
                        </div>
                        {{-- <div class="form-group col-md-12">
                            <label for="exampleFormControlSelect1">Estado</label>
                            <select class="form-control" v-model='editLibro.estado'>
                                <option value="prestado">Prestado</option>
                                <option value="disponible">Disponible</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('js/libro.js') }}"></script>
@endsection