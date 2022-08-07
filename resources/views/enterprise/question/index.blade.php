@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Questions</div>
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
                        <button
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                        >Add Question</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form method="POST" action="{{route('question.store')}}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Question</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="question" class="col-form-label">Question<span class="text-danger">*</span></label>
                                                <input type="text" id="question" class="form-control @error('question') is-invalid @enderror" name="question" placeholder=".... ?" autocomplete="question" value="{{ old('question') }}" autofocus>
                                                <label class="col-form-label">Options<span class="text-danger">*</span></label>

                                                <input type="text" class="form-control @error('option[1]') is-invalid @enderror" name="option[1]" placeholder="option 1" autocomplete="option" value="{{ old('option[1]') }}" autofocus>
                                                <input type="text" class="form-control @error('option[2]') is-invalid @enderror" name="option[2]" placeholder="option 2" autocomplete="option" value="{{ old('option[2]') }}" autofocus>
                                                <div id="optionsdiv">

                                                </div>
                                                <button type="button" class="btn btn-light" onclick="addOption()">+</button>
                                                <script>
                                                    function addOption() {
                                                        const element = document.getElementById("optionsdiv");
                                                    }
                                                </script>
                                                @error('question')
                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit the application</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
