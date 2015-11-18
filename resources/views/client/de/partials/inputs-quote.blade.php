<div class="panel-body ">
    <div class="col-xs-12 col-md-6">
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Nombres: </label>
            <div class="col-lg-9">
                {!! Form::text('first_name', old('first_name', $client->first_name), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Nombres',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('first_name') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Ap. Paterno: </label>
            <div class="col-lg-9">
                {!! Form::text('last_name', old('last_name', $client->last_name), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Ap. Paterno',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('last_name') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Ap. Materno: </label>
            <div class="col-lg-9">
                {!! Form::text('mother_last_name', old('mother_last_name', $client->mother_last_name), [
                    'class' => 'form-control',
                    'placeholder' => 'Ap. Materno',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('mother_last_name') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Ap. de casada: </label>
            <div class="col-lg-9">
                {!! Form::text('married_name', old('married_name', $client->married_name), [
                    'class' => 'form-control',
                    'placeholder' => 'Ap. de casada',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('married_name') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Estado Civil: </label>
            <div class="col-lg-9">
                {!! SelectField::input('civil_status', $data['civil_status']->toArray(), [
                    'class' => 'select-search'],
                    old('civil_status', $client->civil_status)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('civil_status') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Tipo de documento:</label>
            <div class="col-lg-9">
                {!! SelectField::input('document_type', $data['document_type']->toArray(), [
                    'class' => 'select-search'],
                    old('document_type', $client->document_type)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('document_type') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Documento de identidad: </label>
            <div class="col-lg-9">
                {!! Form::text('dni', old('dni', $client->dni), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Documento de identidad',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('dni') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Complemento: </label>
            <div class="col-lg-9">
                {!! Form::text('complement', old('complement', $client->complement), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Complemento',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('complement') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Ext. Documento de identidad: </label>
            <div class="col-lg-9">
                {!! SelectField::input('extension', $data['cities']['CI']->toArray(), [
                    'class' => 'select-search'],
                    old('extension', $client->extension)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('extension') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">País: </label>
            <div class="col-lg-9">
                {!! Form::text('country', old('country', $client->country), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'País',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('country') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Fecha de nacimiento: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                    {!! Form::text('birthdate', old('birthdate', dateToFormat($client->birthdate)), [
                        'class' => 'form-control daterange-single',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('birthdate') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Lugar de nacimiento: </label>
            <div class="col-lg-9">
                {!! Form::text('birth_place', old('birth_place', $client->birth_place), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Lugar de nacimiento',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('birth_place') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Lugar de residencia: </label>
            <div class="col-lg-9">
                {!! SelectField::input('place_residence', $data['cities']['DE']->toArray(), [
                    'class' => 'select-search'],
                    old('place_residence', $client->place_residence)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('place_residence') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Localidad: </label>
            <div class="col-lg-9">
                {!! Form::text('locality', old('locality', $client->locality), [
                    'class' => 'form-control ui-wizard-content',
                    'placeholder' => 'Localidad',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('locality') }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">

        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Dirección: </label>
            <div class="col-lg-9">
                {!! Form::textarea('home_address', old('home_address', $client->home_address), [
                    'size' => '4x4',
                    'class' => 'form-control',
                    'placeholder' => 'Dirección',
                    'autocomplete' => 'off'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('home_address') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Ocupación (CAEDEC): </label>
            <div class="col-lg-9">
                {!! SelectField::input('ad_activity_id', $data['activities']->toArray(), [
                    'class' => 'select-search'],
                    old('ad_activity_id', $client->ad_activity_id)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('ad_activity_id') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Descripción ocupación: </label>
            <div class="col-lg-9">
                {!! Form::textarea('occupation_description', old('occupation_description', $client->occupation_description), [
                    'size' => '4x4',
                    'class' => 'form-control',
                    'placeholder' => 'Descripción ocupación'])
                !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('occupation_description') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Telefono 1: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-phone"></i></span>
                    {!! Form::text('phone_number_home', old('phone_number_home', $client->phone_number_home), [
                        'class' => 'form-control ui-wizard-content',
                        'placeholder' => 'Telefono 1',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('phone_number_home') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Telefono 2: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-phone"></i></span>
                    {!! Form::text('phone_number_mobile', old('phone_number_mobile', $client->phone_number_mobile), [
                        'class' => 'form-control ui-wizard-content',
                        'placeholder' => 'Telefono 2',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('phone_number_mobile') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Telef. Oficina: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-phone"></i></span>
                    {!! Form::text('phone_number_office', old('phone_number_office', $client->phone_number_office), [
                        'class' => 'form-control ui-wizard-content',
                        'placeholder' => 'Telef. Oficina',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('phone_number_office') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3">Correo electónico: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon-mail5"></i></span>
                    {!! Form::email('email', old('email', $client->email), [
                        'class' => 'form-control ui-wizard-content required',
                        'placeholder' => 'mail@email.com',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('email') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Peso: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon">(Kg)</span>
                    {!! Form::text('weight', old('weight', $client->weight), [
                        'class' => 'form-control ui-wizard-content',
                        'placeholder' => 'Peso',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('weight') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-3 label_required">Estatura: </label>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon">(cm)</span>
                    {!! Form::text('height', old('height', $client->height), [
                        'class' => 'form-control ui-wizard-content',
                        'placeholder' => 'Estatura',
                        'autocomplete' => 'off'])
                    !!}
                </div>
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('height') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label label_required">Género: </label>
            <div class="col-lg-9">
                {!! SelectField::input('gender', $data['gender']->toArray(), [
                    'class' => 'select-search'],
                    old('gender', $client->gender)) !!}
                <label id="location-error" class="validation-error-label" for="location">{{ $errors->first('gender') }}</label>
            </div>
        </div>

    </div>
    <div class="text-right">
        {!! Form::button('Cotiza tu mejor seguro <i class="icon-arrow-right14 position-right"></i>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
    </div>
</div>