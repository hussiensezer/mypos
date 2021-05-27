@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.index")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route("dashboard.clients.index")}}"> @lang('site.clients')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang("site.edit")</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    @include("partials._errors")

                    <form action="{{route("dashboard.clients.update",$client->id)}}" method="POST" >
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label> @lang('site.client')</label>
                            <input type="text" name="name" class="form-control" value="{{$client->name}}" >
                        </div> <!-- End Form-Group -->

                        @for($i = 0 ; $i < 2 ; $i++)
                            <div class="form-group">
                                <label> @lang('site.phone')</label>
                                <input type="text" name="phone[]" class="form-control" value="{{$client->phone[$i] ?? ''}}">
                            </div> <!-- End Form-Group -->
                        @endfor

                        <div class="form-group">

                            <label> @lang('site.address')</label>
                            <textarea name="address" class="form-control" > {{$client->address}}</textarea>
                        </div> <!-- End Form-Group -->
                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('site.edit')</button>
                        </div> <!-- End Form-Group -->

                    </form>  <!-- End Form-->
                </div> <!-- End Box Body-->

            </div>




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
