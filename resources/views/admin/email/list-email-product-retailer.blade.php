@extends('admin.layout')

@section('menu-user')
    @include('admin.partials.menu-user')
@endsection

@section('menu-main')
    @include('admin.partials.menu-main')
@endsection

@section('header')
    @include('admin.partials.header')
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="form-wizard-title text-semibold" style="border-bottom: 0px;">
                <span class="form-wizard-count"><i class="icon-file-text2"></i></span>
                Correos electronicos
                <small class="display-block">Listado de registros</small>
            </h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li>
                        <a href="{{route('admin.email.new-add-email', ['nav'=>'email', 'action'=>'new_add_email'])}}" class="btn btn-link btn-float has-text">
                            <i class="icon-file-plus text-primary"></i>
                            <span>Agregar correo a producto</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <table class="table datatable-basic table-bordered">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo electronico</th>
                <th>Producto</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @if(count($query)>0)
                @foreach($query as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->product}}</td>
                        <td>
                            @if((boolean)$data->active==true)
                                <span class="label label-success">Activo</span>
                            @elseif((boolean)$data->active==false)
                                <span class="label label-default">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <ul class="icons-list">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            @if((boolean)$data->active==true)
                                                <a href="#" id="{{$data->id}}|inactive|desactivar" class="confirm_active">
                                                    <i class="icon-cross"></i> Desactivar
                                                </a>
                                            @elseif((boolean)$data->active==false)
                                                <a href="#" id="{{$data->id}}|active|activar" class="confirm_active">
                                                    <i class="icon-checkmark4"></i> Activar
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            <a href="{{route('admin.email.edit-email', ['nav'=>'email', 'action'=>'edit_email', 'ad_email_id'=>$data->ad_email_id])}}">
                                                <i class="icon-pencil3"></i> Editar
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            @else
                <div class="alert alert-warning alert-styled-left">
                    <span class="text-semibold">Warning!</span> No existe ningun registro:<br>
                    - Verifique que el producto en el retailer este activado<br>
                    - Verifique que el producto en la compañia este activado<br>
                    - Ingrese un nuevo registro
                </div>
            @endif
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('a[href].confirm_active').click(function(e){

                var _id = $(this).prop('id');
                var arr = _id.split("|");
                var id_retailer_product_email = arr[0];
                var text = arr[1];
                bootbox.confirm("Esta seguro de "+arr[2]+" el correo electronico ?", function(result) {
                    if(result){
                        //bootbox.alert("Confirm result: " + result+ "/" +id_user);
                        $.get( "{{url('/')}}/admin/email/active_ajax/"+id_retailer_product_email+"/"+text, function( data ) {
                            console.log(data);
                            if(data==1){
                                window.setTimeout('location.reload()', 1000);
                            }else if(data==0){
                                bootbox.alert("Error!! no se actualizo el dato, vuelva a intentarlo otra vez");
                            }
                        });
                    }
                });

            });
        });
    </script>
@endsection