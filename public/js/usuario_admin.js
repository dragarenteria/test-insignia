new Vue ({
    el:'#main_usuario',
    data:{
        usuario:{},
        tabla:'',
        usuarioEdit:{}
    },
    mounted(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        this.datatable()

    },
    methods:{
        crearUsuario(){
            if (this.usuario.password == this.usuario.c_password) {
                $.ajax({
                    type: "post",
                    url: "/registro",
                    data: this.usuario,
                    success: response => {
                        
                        if (response.status) {
                            swal({
                                title: "Genial!",
                                text: `Registro exitoso`,
                                icon: "success",
                              })
                              this.usuario = {}
                              this.tabla.ajax.reload();
                              $('#nuevo_usuario').modal('hide')

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
            
        },
        editarUsuario(){
            $.ajax({
                type: "post",
                url: "/editar",
                data: this.usuarioEdit,
                success: response => {
                    if (response.status) {
                        swal({
                            title: "Genial!",
                            text: `Registro exitoso`,
                            icon: "success",
                          })
                          this.tabla.ajax.reload();
                          $('#editar_usuario').modal('hide')

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
                    
        },
        eliminarUsuario(id){
            let self = this;
            swal({
                    title: "Esta seguro de eliminar ?",
                    text: "Al eliminar este usuario no lo podrá recuperar nuevamente.",
                    icon: "warning",
                    buttons: [true, "Continuar"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // Eliminar el docente
                        $.ajax({
                            type: "DELETE",
                            url: `/eliminar/${id}`,
                            success: response => {
                                if (response.status) {
                                    this.tabla.ajax.reload();
                                    swal({
                                        text: "Usuario eliminado correctamente",
                                        icon: "success",
                                        buttons: [null, "Perfecto!"],
                                    });
                                } else {
                                    swal({
                                        text:'No puede eliminar éste usuario porque ya ha prestado un libro',
                                        icon:'error',
                                        buttons: [null, 'OK'],
                                    });
                                }

                            }
                        });

                    } else {
                        swal({
                            text:'Haz cancelado la acción.',
                            timer:2000,
                            buttons: [null, null],
                        });
                    }
                });
        },
        datatable(){
            let self = this
          self.tabla =  $('#tabla_usuario').DataTable({
                'ajax': {
                    'method': 'GET',
                    'url': '/users/getusers',
                },
                columns: [{
                        defaultContent: '1'
                    },
                    {
                        data:  'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data:  'created_at'
                    },
                    {
                        data:  'updated_at'
                    },
                    {
                        defaultContent: `<div class="btn-group"><button data-toggle="modal" data-target="#editar_usuario" class="editar btn btn-primary"><i class="fa fa-edit fa-lg"></i></button>    <button class="eliminar btn btn-danger"><i class="fa fa-trash fa-lg"></i></button></div>`
                    },
                ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": ">",
                        "previous": "<"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
            self.tabla.on('order.dt search.dt', function () {
                self.tabla.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
            $('#tabla_usuario tbody').on('click', 'button.editar', function (d) {
                var data = self.tabla.row($(this).parents('tr')).data();
                // Enviamos los datos al mentodo preparado para gestionar esta data
                self.usuarioEdit = data
                
            });
            $('#tabla_usuario tbody').on('click', 'button.eliminar', function (d) {
                var data = self.tabla.row($(this).parents('tr')).data();
                // Enviamos los datos al mentodo preparado para gestionar esta data
                // self.elmiLibro=data
                self.eliminarUsuario(data.id)
            });
        }
    }
})