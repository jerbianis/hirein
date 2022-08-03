@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Enterprise Profile</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('status-danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status-danger') }}
                            </div>
                        @endif
                        <img
                            src="{{asset('storage/logo/'.$enterprise->logo)}}"
                            class="mx-auto d-block img-thumbnail rounded-circle w-25 mb-3"
                            alt="enterprise logo"
                        >
                        <form method="POST" action="{{route('profile.edit.logo')}}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="row mb-3">
                                <label for="logo" class="col-md-4 col-form-label text-md-end">Logo</label>
                                <div class="col-md-6">
                                    <input id="logo"
                                           type="file"
                                           accept="image/jpeg,image/png"
                                           class="form-control @error('logo') is-invalid @enderror"
                                           name="logo"
                                           oninput="enableButton(1)"
                                    >

                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="button1" class="btn btn-primary" disabled>Upload Logo</button>
                        </form>
                        @if ($enterprise->logo != 'logo.jpg')
                            <form method="POST" action="{{route('profile.delete.logo')}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete Logo</button>
                            </form>
                        @endif
                        <form method="POST" action="{{route('profile.edit.enterprise')}}">
                            @method('PUT')
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input oninput="enableButton(2)" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $enterprise->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3" >
                                <label for="main_activity" class="col-md-4 col-form-label text-md-end">Main Activity <span class="text-danger">*</span>
                                    <a
                                        target="_blank"
                                        href="http://www.tunisieindustrie.nat.tn/fr/doc.asp?action=showdoc&docid=555#14"
                                        style="color: #0d6efd"
                                    ><span
                                            class="text-primary"> ?</span></a></label>

                                <div class="col-md-6">
                                    <select
                                        id="main_activity"
                                        name="main_activity"
                                        class="form-select form-control @error('main_activity') is-invalid @enderror"
                                        oninput="enableButton(2)"
                                    >
                                        @foreach(\App\Enum\MainActivityEnum::cases() as $option)
                                            <option
                                                value="{{$option->name}}"
                                                @if ($option->name === $enterprise->main_activity->name)
                                                    disabled selected
                                                @endif
                                            >{{$option->value}}</option>
                                        @endforeach
                                    </select>

                                    @error('main_activity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="manager_name" class="col-md-4 col-form-label text-md-end">Manager Name</label>
                                <div class="col-md-6">
                                    <input oninput="enableButton(2)" id="manager_name" type="text" class="form-control @error('manager_name') is-invalid @enderror" name="manager_name" value="{{ $enterprise->manager_name }}" autocomplete="manager_name">

                                    @error('manager_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                                <div class="col-md-6">
                                    <textarea
                                        id="description"
                                        class="form-control
                                        @error('description') is-invalid @enderror"
                                        name="description"
                                        autocomplete="description"
                                        oninput="enableButton(2)"
                                    >{{$enterprise->description}}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 form-check form-switch">
                                <label for="is_open_for_hiring" class="form-check-label">Open for hiring</label>
                                <input id="is_open_for_hiring"
                                       type="checkbox"
                                       class="form-control form-check-input"
                                       name="is_open_for_hiring"
                                       oninput="enableButton(2)"
                                       @if ($enterprise->is_open_for_hiring)
                                           checked
                                       @endif
                                       autofocus>
                            </div>
                            <button type="submit" id="button2" class="btn btn-primary" disabled>Update Profile Information</button>
                        </form>
                        <script>
                            function enableButton(x) {
                                document.getElementById('button'+x).disabled=false;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
