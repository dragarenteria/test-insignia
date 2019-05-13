new Vue ({
    el:'#main_registro',
    data:{
        datosRegistro:{},
    },
    mounted(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    },
    methods:{
        registrar(){
            if (this.datosRegistro.password == this.datosRegistro.c_password) {
                $.ajax({
                    type: "post",
                    url: "/registro",
                    data: this.datosRegistro,
                    success: response => {
                        // console.log(response);
                        
                        if (response.status) {
                            swal({
                                title: "Genial!",
                                text: `Registro exitoso`,
                                icon: "success",
                              })
                              this.datosRegistro = {}
                              
                        }else if (response.error.email) {
                            swal({
                                title: "Error",
                                text: `Ya exites un usuario con éste email`,
                                icon: "error",
                              })
                        }
                        else{
                            swal({
                                title: "Error",
                                text: `No se pudo realizar el registro`,
                                icon: "error",
                              })
                        }
                    }
                });
                
            }else{
                swal({
                    title: "Error",
                    text: `Las contraseñas deben ser iguales`,
                    icon: "error",
                  })
            }
            
        }

    }
})