@extends ('backend.layouts.app')

@section ('title', isset($title) ? $title : 'Edit Device Info')

@section('page-header')
    <h1>
        Device Info
        <small>Edit</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($item, ['route' => [$repository->getActionRoute('updateRoute'), $item], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', 'Name :', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('udid', 'UDID :', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('udid', null, ['class' => 'form-control', 'placeholder' => 'UDID', 'required']) }}
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('devicetype', 'Device Type :', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::select('devicetype', ['android' => 'Android', 'ios' => 'iOS'], $item->devicetype, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('token', 'Token :', ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('token', null, ['class' => 'form-control', 'placeholder' => 'Token', 'required']) }}
                    </div>
                </div>
            </div>
            
        </div>

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route($repository->getActionRoute('listRoute'), 'Cancel', [], ['class' => 'btn btn-danger btn-xs']) }}
                </div>

                <div class="pull-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-success btn-xs']) }}
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    {{ Form::close() }}
@endsection