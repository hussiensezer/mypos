@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.category')</h1>

            <ol class="breadcrumb">
                <li>  <i class="fa fa-dashboard"></i> <a href="{{route("dashboard.welcome")}}">@lang('site.dashboard')</a></li>
                <li class=""><a href="{{route("dashboard.categories.index")}}"> @lang('site.categories')</a></li>
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

                    <form action="{{route("dashboard.categories.update",$category->id)}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                {{--  site.ar.name  --}}
                                <label> @lang('site.' . $locale . '.category')</label>
                                {{--             ar[name]                   --}}
                                <input type="text" name="{{$locale}}[name]" class="form-control" value="{{$category->translate($locale)->name}}" >
                            </div> <!-- End Form-Group -->
                            @endforeach


                        <div class="form-group">
                            <button class="btn btn-success"><i class="fa fa-edit"></i> @lang('site.update')</button>
                        </div> <!-- End Form-Group -->

                    </form>  <!-- End Form-->
                </div> <!-- End Box Body-->

            </div>




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
