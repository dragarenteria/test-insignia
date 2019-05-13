new Vue ({
    el:'#main_password',
    data:{
        pass:{}
    },
    mounted(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        // alert('sdfs')
    },
    methods:{
        editar_contraseña(){
            console.log(this.pass);

            if (this.pass.pass_nueva == this.pass_confirmar) {
                swal({
                    title: "Error!",
                    text: `La contraseña nueva y de confirmación deben ser iguales`,
                    icon: "error",
                  })

            }else{
                $.ajax({
                    type: "post",
                    url: "/editpass",
                    data: this.pass,
                    success: function (resp) {
                        // console.log(resp);
                        
                        if (resp.status) {
                            swal({
                                title: "Genial!",
                                text: `Contraseña editada`,
                                icon: "success",
                              })
                              this.pass = {}
                             
                        }else if(resp.pass == true){
                            swal({
                                title: "Error",
                                text: `La contraseña actual no conincide con la contraseña nueva`,
                                icon: "error",
                              })
                        }
                        else{
                            swal({
                                title: "Error",
                                text: `No se pudo editar la contraseña`,
                                icon: "error",
                              })
                        }
                    }
                });
            }

        }
    }
})