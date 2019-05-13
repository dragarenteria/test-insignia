@extends('layouts.app')

@section('content')
<div class="container" id="main_password">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"> <h4 class="text-center">Editar contraseña</h4> </div>

                <form @submit.prevent="editar_contraseña()" class="card-body">
                   <div class="row">
                        <div class="form-group col-md-12">
                                <label for="">Contraseña actual <span class="text-danger">*</span></label>
                                <input  type="password" required class="form-control"
                                 v-model="pass.pass_actual"   placeholder="Contraseña actual">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Nueva contraseña <span class="text-danger">*</span></label>
                                <input type="password" required class="form-control"
                                v-model="pass.pass_nueva"  placeholder="Nueva contraseña">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Confirmar contraseña <span class="text-danger">*</span></label>
                                <input type="password" required class="form-control"
                                v-model="pass.pass_confirmar"  placeholder="Confirmar contraseña">
                            </div>
                            <div class="form-group col-md-12">
                                   <button type="submit" class="btn btn-primary btn-block">Editar contraseña</button>
                                </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/password.js') }}"></script>
@endsection

