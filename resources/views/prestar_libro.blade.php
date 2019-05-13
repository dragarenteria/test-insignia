@extends('layouts.app')

@section('content')
<div class="container" id="main_prestar">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3 class="text-center">
                    <button data-toggle="modal" data-target="#nuevo_prestamo" class="btn btn-primary"><i
                            class="fas fa-plus"></i> Nuevo prestamo</button>
                </h3></div>
                <div class="card-body table-responsive">

                        <table class="table table-striped text-center" id="tabla_prestamo">
                            <thead>
                                <th>#</th>
                                <th>Libro</th>
                                <th>Uusario</th>
                                <th>Fecha de prestamo</th>
                                <th>Fecha de devolución</th>
                                <th>Opciones</th>
                            </thead>
    
                        </table>
    
                    </div>
            </div>
        </div>
    </div>

    {{-- modal nuevo libro --}}
    <form @submit.prevent="crearPrestamos" class="modal fade" id="nuevo_prestamo" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Nuevo prestamo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-center">Nota: Recuerde que solo puede prestar libros registrados por usted y a usuarios diferentes a usted</h5>
                            {{-- {{$id}}  --}}
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlSelect1">Elegir libro</label>
                            <select class="form-control" v-model='prestar.libro'>
                              <option>Seleccione un libro</option>
                              <option v-for='libro in libros' :value="libro.id">@{{libro.nombre_libro}}</option>

                            </select>
                            <small v-if="libros.length == 0">Si no encuentra libors en la lista desplegable es porque posiblimente no hay libros registrados o éstan todos prestados</small>
                          </div>
                        <div class="form-group col-md-12">
                            <label for="exampleFormControlSelect1">Prestar a:</label>
                            <select class="form-control" v-model='prestar.user'>
                              <option>Seleccione un usuario</option>
                              <option v-for='user in usuarios' :value="user.id">@{{user.name}}</option>
                            </select>
                                <small v-if="usuarios.length == 0">Si no encuentra usuarios en la lista desplegable es porque posiblimente no hay más usuarios registrados</small>
                          </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Prestar</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script src="{{ asset('js/prestar.js') }}"></script>
@endsection