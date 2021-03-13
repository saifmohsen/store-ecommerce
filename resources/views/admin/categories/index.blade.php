@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title"> الاقسام الرئيسية </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('Admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active"> الاقسام الرئيسية
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->
                <section id="dom">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">جميع الاقسام الرئيسية </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <table
                                            class="table display nowrap table-striped table-bordered scroll-horizontal col-12">
                                            <thead class="">
                                            <tr >
                                                <th scope="col">الاسم </th>
                                                <th scope="col"> الاسم بالرابط </th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">صوره القسم</th>
                                                <th scope="col">الإجراءات</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @isset($categories) {{-- يعني القيمة مش null --}}
                                                @foreach($categories as $category)
                                                    <tr>
                                                        <td>{{$category -> name}}</td>

                                                        <td>{{$category -> slug}}</td>
                                                        <td>{{$category -> getActive()}}</td>
                                                        <td> <img style="width: 150px; height: 100px;" src=" "></td>
                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <a href="{{route('main-categories.edit',$category -> id)}}"
                                                                   class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                            {{-- طبعا ال name تبع resource route بقدر اجيبه من خلال امر php artisan route list وفيه طريقة ع النت بقدر اضيفه ع resource route نفسه  --}}

                                                                {{--<a href="{{ route('admin.category.delete', $category->id) }}"
                                                                class="btn btn-outline-danger btn-min-width box-shadow-3
                                                                mr-1 mb-1">حذف</a>--}}

                                                                <form method="POST" action="{{ route('main-categories.destroy',$category->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3
                                                                mr-1 mb-1">حذف</button>
                                                                </form>
                                                            {{-- سبب اني استخدمت form بدلا من اني استخدم a --}}
                                                                {{--With the <a> tag you are sending a get request. So it
                                                                could be used to get route like the show route:

                                                                <a href="{{ route('users.show',$user->id) }}">show
                                                            </
                                                            >
                                                            For delete, use a
                                                            <form> instead, with a input named _method with value
                                                                delete, and csrf field:

                                                                <form method="POST"
                                                                      action="{{ route('users.destroy',$user->id) }}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('delete') }}
                                                                    <button type="submit">delete</button>
                                                                </form>--}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endisset


                                            </tbody>
                                        </table>
                                        <div class="justify-content-center d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@stop
