new Vue({
    el:'#main_libro',
    data:{
        nuevoLibro:{},
        tabla:'',
        editLibro:{},
        elmiLibro:{}
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
        crearLibro(){
            $.ajax({
                type: "post",
                url: "/libros/crear",
                data: this.nuevoLibro,
                success: response => {
                    // console.log(response);

                    if (response.status) {
                        swal({
                            title: "Genial!",
                            text: `Registro exitoso`,
                            icon: "success",
                          })
                          this.nuevoLibro = {}
                          this.tabla.ajax.reload();
                          $('#nuevo_libro').modal('hide');
                    }else{
                        swal({
                            title: "Error",
                            text: `No se pudo realizar el registro`,
                            icon: "error",
                          })
                    }
                }
            });
            
        },
        editarLibro(){
            $.ajax({
                type: "post",
                url: "/libros/editar",
                data: this.editLibro,
                success: response => {
                    console.log(response);

                    if (response.status) {
                        swal({
                            title: "Genial!",
                            text: `Datos editados correctamente`,
                            icon: "success",
                          })
                          this.editLibro = {}
                          this.tabla.ajax.reload();
                          $('#editar_libro').modal('hide');
                    }else{
                        swal({
                            title: "Error",
                            text: `No se pudieron reditar los datos`,
                            icon: "error",
                          })
                    }
                }
            });
        },
        eliminarLibro(){
            if (this.elmiLibro.estado == 'prestado') {
                swal({
                    title: "Error",
                    text: `No puede eliminar éste libro porque lo ha prestado`,
                    icon: "error",
                  })
            }else{
                let self = this;
            swal({
                    title: "Esta seguro de eliminar ?",
                    text: "Al eliminar este libro no lo podrá recuperar nuevamente.",
                    icon: "warning",
                    buttons: [true, "Continuar"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        // Eliminar el docente
                        $.ajax({
                            type: "DELETE",
                            url: `/libros/eliminar/${self.elmiLibro.id}`,
                            success: function (response) {
                                if (response.status) {
                                    self.tabla.ajax.reload();
                                    swal(response.mensaje, {
                                        icon: "success",
                                        buttons: [null, "Perfecto!"],
                                    });
                                } else {
                                    swal({
                                        text:'No puede eliminar éste libro porque ya ha sido prestado',
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
            }
        },
        datatable(){
            let self = this
          self.tabla =  $('#tabla_libro').DataTable({
                'ajax': {
                    'method': 'GET',
                    'url': '/libros/getlibros',
                },
                columns: [{
                        defaultContent: '1'
                    },
                    {
                        data:  'autor'
                    },
                    {
                        data: 'nombre_libro'
                    },
                    {
                        data:  'genero'
                    },
                    {
                        data:  'num_paginas'
                    },
                    {
                        data:  'estado'
                    },
                    {
                        defaultContent: `<div class="btn-group"><button data-toggle="modal" data-target="#editar_libro" class="editar btn btn-primary"><i class="fa fa-edit fa-lg"></i></button>    <button class="eliminar btn btn-danger"><i class="fa fa-trash fa-lg"></i></button></div>`
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
            $('#tabla_libro tbody').on('click', 'button.editar', function (d) {
                var data = self.tabla.row($(this).parents('tr')).data();
                // Enviamos los datos al mentodo preparado para gestionar esta data
                self.editLibro = data
                
            });
            $('#tabla_libro tbody').on('click', 'button.eliminar', function (d) {
                var data = self.tabla.row($(this).parents('tr')).data();
                // Enviamos los datos al mentodo preparado para gestionar esta data
                self.elmiLibro=data
                self.eliminarLibro()
            });
        }
    }
})