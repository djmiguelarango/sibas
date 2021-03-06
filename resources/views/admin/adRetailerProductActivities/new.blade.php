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
            <h5 class="panel-title"><i class="icon-plus2"></i> Nueva Asignación</h5>
            <hr />
        </div>

        <div class="panel-body">

            {!! Form::open(array('route' => 'create_ad_retailer_product_activities', 'name' => 'Form', 'id' => 'ad_retailer_product_activities', 'method'=>'post', 'class'=>'form-horizontal form-validate-jquery')) !!}
                <fieldset class="content-group">
                    <div class="form-group">
                        <label class="control-label col-lg-2 label_required">Producto</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="adRetailerProductActivities" id="adRetailerProductActivities" required="required">
                                <option value="">Seleccione</option>
                                @foreach($retailerProducts as $products)
                                    @if($products->mostrar == 1)
                                        <option value="{{ $products->id }}">{{ $products->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2 label_required">Multiple select</label>
                        <div class="col-lg-5">
                            <select class="form-control" multiple="multiple" id="adActivities" name="adActivities[]" required="required" data-popup="tooltip" title="Presione la tecla [Ctrl] para seleccionar mas opciones">
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->occupation }}</option>      
                                @endforeach
                            </select>
                        </div>
                    </div>

                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        Guardar <i class="icon-floppy-disk position-right"></i>
                    </button>
                    <a href="{{ route('adRetailerProductActivities') }}" class="btn btn-danger">
                        Cancelar <i class="icon-arrow-right14 position-right"></i>
                    </a>
                </div>
            {!!Form::close()!!}

        </div>
    </div>
@endsection