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
        <h5 class="panel-title"><i class="icon-plus2"></i> Nuevo Modelo</h5>
        <hr />
    </div>

    <div class="panel-body">

        {!! Form::open(array('route' => 'create_vehicle_models', 'name' => 'Form', 'id' => 'ad_vehicle_models', 'method'=>'post', 'class'=>'form-horizontal form-validate-jquery')) !!}
        <fieldset class="content-group">
            <div class="form-group">
                <label class="control-label col-lg-2 label_required">Modelo</label>
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-text-width"></i></span>
                        <input type="hidden" class="form-control" value="{{ $make->id }}" name="ad_vehicle_make_id" id="ad_vehicle_make_id">
                        <input type="text" placeholder="Modelo" class="form-control" name="model" id="model" required="required">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2 label_required">Activar</label>
                <div class="col-lg-5">
                    <input type="checkbox" class="styled tipode" name="active" id="active">
                </div>
            </div>
        </fieldset>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">
                Guardar <i class="glyphicon glyphicon-floppy-disk position-right"></i>
            </button>
            <a href="{{route('admin.vehicle_models.list', ['nav'=>'ad_vehicle_models', 'action'=>'list', 'id_make'=>$make->id ])}}" class="btn btn-danger">
                Cancelar <i class="glyphicon glyphicon-remove position-right"></i>
            </a>
        </div>
        {!!Form::close()!!}
    </div>
</div>
@endsection