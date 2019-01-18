@extends('layouts.app')
@section('added_css')

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="box">
            <div class="box-header with-border">
                <h4 class="box-title">Responsive Hover Table</h4>
                <div class="box-controls pull-right">
                    <div class="lookup lookup-circle lookup-right">
                        <input type="text" name="s">
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <p>hello {{$demande->id}}</p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@push('added_scripts')




@endpush
