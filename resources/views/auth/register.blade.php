@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }} <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 text-center">

                                <label for="candidate" class=" col-form-label text-md-end">Candidate</label>

                                <input id="candidate" type="radio" value="candidate" class=" @error('role') is-invalid @enderror" name="role" onchange="displayregister()" required>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="col-md-6 text-center">

                                <label for="enterprise" class=" col-form-label text-md-end">Enterprise</label>

                                <input id="enterprise" type="radio" value="enterprise" class=" @error('role') is-invalid @enderror" name="role" onchange="displayregister()" required>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-3 candidateregister" style="display: none;">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">Birth Date <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" autocomplete="birth_date">

                                @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 candidateregister" style="display: none;">
                            <label for="job_title" class="col-md-4 col-form-label text-md-end">Job Title</label>
                            <div class="col-md-6">
                                <input id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}"  autocomplete="job_title">

                                @error('job_title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 enterpriseregister" style="display: none;">
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
                                    >
                                    <option value="" disabled selected>Main Activity</option>
                                    <?php use \App\Enum\MainActivityEnum; ?>
                                    @foreach(MainActivityEnum::cases() as $option)
                                        <option value="{{$option->name}}" >{{$option->value}}</option>
                                    @endforeach
                                </select>

                                @error('main_activity')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 enterpriseregister" style="display: none;">
                            <label for="manager_name" class="col-md-4 col-form-label text-md-end">Manager Name</label>
                            <div class="col-md-6">
                                <input id="manager_name" type="text" class="form-control @error('manager_name') is-invalid @enderror" name="manager_name" value="{{ old('manager_name') }}" autocomplete="manager_name">

                                @error('manager_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displayregister() {
        var candidate = document.getElementsByClassName("candidateregister");
        var enterprise = document.getElementsByClassName("enterpriseregister");
        if (document.getElementById("enterprise").checked) {
            candidate[0].style.display = "none";
            candidate[1].style.display = "none";
            enterprise[0].style.display = "block";
            enterprise[1].style.display = "block";
            document.getElementById("main_activity").required = true;
            document.getElementById("birth_date").required = false;
        } else {
            enterprise[0].style.display = "none";
            enterprise[1].style.display = "none";
            candidate[0].style.display = "block";
            candidate[1].style.display = "block";
            document.getElementById("main_activity").required = false;
            document.getElementById("birth_date").required = true;
        }
    }
</script>

@endsection
