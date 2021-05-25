@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.index")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route("dashboard.users.index")}}"> @lang('site.users')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang("site.add")</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include("partials._errors")

                    <form action="{{route("dashboard.users.store")}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="form-group">
                            <label> @lang('site.first_name')</label>
                            <input type="text" name="first_name" class="form-control" value="{{old('first_name')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.last_name')</label>
                            <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.email')</label>
                            <input type="email" name="email" class="form-control" value="{{old('email')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.image')</label>
                            <input type="file" name="image" class="form-control image" >
                        </div> <!-- End Form-Group -->
                            <div class="form-group">
                                <img src="" alt="" class="image-preview img-thumbnail" style="width:100px; display:none">
                            </div>
                        <div class="form-group">
                            <label> @lang('site.password')</label>
                            <input type="password" name="password" class="form-control" value="{{old('password')}}" >
                        </div> <!-- End Form-Group -->

                        <div class="form-group">
                            <label> @lang('site.password_confirmed')</label>
                            <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmed')}}" >
                        </div> <!-- End Form-Group -->
                        <div class="form-group">
                            <label for="">@lang('site.permissions')</label>
                            <!--  Start Tab Permissions -->
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                @php
                                    $models = ['users','categories','products'];
                                    $maps = ['create','read','update','delete'];
                                @endphp
                                <ul class="nav nav-tabs">
                                    @foreach($models as $index => $model)
                                      <li class="{{ $index == 0 ? 'active': '' }}"><a href="#{{$model}}" data-toggle="tab">@lang('site.'. $model)</a></li>
                                    @endforeach
                                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                                </ul>
                                <div class="tab-content">
                                    @foreach($models as $index => $model)
                                    <div class="tab-pane {{ $index == 0 ? 'active': '' }}" id="{{$model}}">
                                        <b>@lang('site.choose_permissions')</b>
                                        <!-- checkbox -->
                                        <div class="form-group" style="margin-top:10px;">
                                            @foreach($maps  as $map)
                                                <label style="display: inline-block; margin: 0 10px;" > <input type="checkbox" name="permissions[]" value="{{$model .'_' .$map}}"> @lang('site.' . $map) </label>
                                            @endforeach

                                        </div>
                                        <!-- End Check Box-->
                                    <!-- /.tab-pane -->

                                </div>
                                <!-- /.tab-content -->
                                @endforeach
                            </div>
                            <!-- nav-tabs-custom -->
                            <!--  End Tab  Permissions-->   `~
                        </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('site.add')</button>
                        </div> <!-- End Form-Group -->

                    </form>  <!-- End Form-->
                </div> <!-- End Box Body-->

            </div>




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
