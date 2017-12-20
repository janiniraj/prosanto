@extends ('backend.layouts.app')

@section ('title', 'Push Notification')

@section('page-header')
<h1>
    Push Notification
    <small>Push Notification</small>
</h1>
@endsection

@section('content')
{{ Form::open(['route' => 'admin.pushnotification.sendnotification', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Send Push Notification</h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="form-group">
            {{ Form::label('name', 'Message', ['class' => 'col-lg-2 control-label']) }}

            <div class="col-lg-10">
                {{ Form::textarea('name', null, ['required' => 'required', 'class' => 'form-control', 'placeholder' => 'Message to send']) }}
            </div><!--col-lg-10-->
        </div><!--form control-->

        <div class="form-group">
            {{ Form::label('device_type', 'Device Type', ['class' => 'col-lg-2 control-label']) }}

            <div class="col-lg-10">
                {{ Form::select('device_type', array('all' => 'All', 'android' => 'All Android', 'ios' => 'All iOS'), 'all', ['class' => 'form-control']) }}
            </div><!--col-lg-10-->
        </div><!--form control-->

    </div><!-- /.box-body -->
</div><!--box-->

<div class="box box-info">
    <div class="box-body">
        <div class="pull-left">
            {{ link_to_route('admin.device.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
        </div><!--pull-left-->

        <div class="pull-right">
            {{ Form::submit('Create', ['class' => 'btn btn-success btn-xs']) }}
        </div><!--pull-right-->

        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->

{{ Form::close() }}
@endsection

