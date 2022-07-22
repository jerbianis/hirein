@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Candidate Profile</div>


                    <div class="card-body">

                        <img
                            src="{{asset('storage/profile_pictures/'.$candidate->picture)}}"
                            class="mx-auto d-block img-thumbnail rounded-circle w-25 mb-3"
                            alt="candidate picture"
                        >

                        <form method="POST" action="{{route('profile.edit.picture')}}" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="row mb-3">
                                <label for="picture" class="col-md-4 col-form-label text-md-end">Profile Picture</label>
                                <div class="col-md-6">
                                    <input id="picture"
                                           type="file"
                                           accept="image/jpeg,image/png"
                                           class="form-control @error('picture') is-invalid @enderror"
                                           name="picture"
                                           oninput="enableButton(1)"
                                    >

                                    @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="button1" class="btn btn-primary" disabled>Upload Picture</button>
                        </form>

                        <form action="">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input oninput="enableButton(2)" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$candidate->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="birth_date" class="col-md-4 col-form-label text-md-end">Birth Date <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input oninput="enableButton(2)" id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ $candidate->birth_date }}" autocomplete="birth_date">

                                    @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="job_title" class="col-md-4 col-form-label text-md-end">Job Title</label>
                                <div class="col-md-6">
                                    <input oninput="enableButton(2)" id="job_title" type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ $candidate->job_title }}"  autocomplete="job_title">

                                    @error('job_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="profile_resume" class="col-md-4 col-form-label text-md-end">Profile Resume</label>
                                <div class="col-md-6">
                                    <textarea
                                        id="profile_resume"
                                        class="form-control
                                        @error('profile_resume') is-invalid @enderror"
                                        name="profile_resume"
                                        autocomplete="profile_resume"
                                        oninput="enableButton(2)"
                                    >{{$candidate->profile_resume}}</textarea>
                                    @error('profile_resume')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 form-check form-switch">
                                <label for="is_open_for_job" class="form-check-label">Open for job</label>
                                <input id="is_open_for_job"
                                       type="checkbox"
                                       class="form-control form-check-input"
                                       name="is_open_for_job"
                                       oninput="enableButton(2)"
                                       @if ($candidate->is_open_for_job)
                                           checked
                                       @endif
                                       autofocus>
                            </div>
                            <button type="submit" id="button2" class="btn btn-primary" disabled>Update Profile Information</button>
                        </form>
                        <form action="" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="CV_file" class="col-md-4 col-form-label text-md-end">CV PDF</label>
                                <div class="col-md-6">
                                    <input oninput="enableButton(3)" id="CV_file" type="file" accept="application/pdf" class="form-control @error('CV_file') is-invalid @enderror" name="CV_file">

                                    @error('CV_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" id="button3" class="btn btn-primary" disabled>Upload CV</button>
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
