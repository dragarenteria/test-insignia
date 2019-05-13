
new Vue ({
    el:'#main_prestar',
    data:{
        prestar:{
            libro: 'Seleccione un libro',
            user:'Seleccione un usuario'
        },
        tabla:'',
        usuarios:[],
        libros:[],

    },
    mounted(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        this.datatable()
        this.datosSelect()
    },
    methods:{
        //Recargar la pagina al insertar
        datosSelect(){
            $.ajax({
                type: "get",
                url: "/prestar-libros/datosSelect",
                data: this.prestar,
                success: response => {
                    this.usuarios = response.users
                    this.libros = response.libros
                }
            });
        },
        crearPrestamos(){
            if (this.prestar.libro == 'Seleccione un libro') {
                swal({
                    title: "Error!",
                    text: `Debe seleccionar un libro`,
                    icon: "error",
                  })
            }else if(this.prestar.user == 'Seleccione un usuario'){
                swal({
                    title: "Error!",
                    text: `Debe seleccionar un usuario`,
                    icon: "error",
                  })
            }else{

                $.ajax({
                    type: "post",
                    url: "/prestar-libros/setprestamo",
                    data: this.prestar,
                    success: response => {
                        console.log(response);
    
                        if (response.status) {
                            swal({
                                title: "Genial!",
                                text: `Libro prestado exitosamente`,
                                icon: "success",
                              })
                              this.prestar.libro = 'Seleccione un libro'
                              this.prestar.user = 'Seleccione un usuario'
                              this.tabla.ajax.reload();
                              $('#nuevo_prestamo').modal('hide');
                              this.datosSelect()
                        }else{
                            swal({
                                title: "Error",
                                text: `No se prestar el libro`,
                                icon: "error",
                              })
                        }
                    }
                });
            }
        },
        datatable(){
            let self = this
          self.tabla =  $('#tabla_prestamo').DataTable({
                'ajax': {
                    'method': 'GET',
                    'url': '/prestar-libros/getprestamo',
                },
                columns: [{
                        defaultContent: '1'
                    },
                    {
                        data:  'libros.nombre_libro'
                    },
                    {
                        data: 'users.name'
                    },
                    {
                        data:  'created_at'
                    },
                    {
                        render(data, type, row) {
                            if (row.created_at == row.updated_at) {
                                return 'Aún no se ha devuelto el libro'
                            }else{
                                return row.updated_at
                            }
                            
                        }
                    },
                    {
                        render(data, type, row) {
                            if (row.estado == 'disponible') {
                                return 'Libro devuelto'
                            }else{
                                return `<div class="btn-group"><button data-toggle="modal" data-target="#editar_libro" class="editar btn btn-primary">Regresar libro</button></div>`
                            }
                            
                        }
                        // defaultContent: 
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
            $('#tabla_prestamo tbody').on('click', 'button.editar', function (d) {
                var datos = self.tabla.row($(this).parents('tr')).data();
                // Enviamos los datos al mentodo preparado para gestionar esta data
                self.regresarLibro = datos.id
                $.ajax({
                    type: "post",
                    url: "/prestar-libros/putprestamo",
                    data: datos ,
                    success: response => {
                        console.log(response);
    
                        if (response.status) {
                            swal({
                                title: "Genial!",
                                text: `Ahora el libro se encuentra disponible`,
                                icon: "success",
                              })
                            
                              self.tabla.ajax.reload();
                            self.datosSelect()

                        }else{
                            swal({
                                title: "Error",
                                text: `No se pudo regresar el libro`,
                                icon: "error",
                              })
                        }
                    }
                });
                
            });
            
        }
    }
})