@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{$jobOffer->title}}</div>

                    <div class="card-body">

                        @if ($can_reject_the_rest)
                            <form method="POST" action="{{route('jobOffer.candidatures.reject_the_rest',$jobOffer)}}">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject the rest</button>
                            </form>
                        @endif

                        @foreach ($candidatures as $candidature)
                            <div>
                                <div>
                                    <img
                                        src="{{asset('storage/profile_pictures/'.$candidature->candidate->picture)}}"
                                        class="mx-auto d-block img-thumbnail rounded-circle w-25 mb-3"
                                        alt="candidate picture"
                                    >
                                </div>
                                <div>
                                    <form method="GET" action="{{route('candidate.show',$candidature->candidate)}}">
                                        <button type="submit" class="btn"><h2>{{$candidature->candidate->name}}</h2></button>
                                    </form>
                                </div>
                                @if ($candidature->candidate->job_title)
                                    <div class="text-secondary" >{{$candidature->candidate->job_title}}</div>
                                @endif
                                <div>Age: {{$candidature->candidate->birth_date}}</div>
                                @if ($candidature->candidate->profile_resume)
                                    <div>Profile Resume: {{$candidature->candidate->profile_resume}}</div>
                                @endif
                                @if ($candidature->candidate->CV_file)
                                    <div class="ratio ratio-4x3 my-1">
                                        <iframe src="{{asset('storage/CV/'.$candidature->candidate->CV_file)}}#view=FitH" >
                                            This browser does not support PDFs.
                                        </iframe>
                                    </div>
                                @endif
                                @if ($candidature->cover_letter)
                                    <h4>Cover Letter</h4>
                                    <div>
                                        {{$candidature->cover_letter}}
                                    </div>
                                @endif
                            </div>
                            <br>
                            <form method="POST" action="{{route('jobOffer.candidatures.update',[$jobOffer,$candidature])}}">
                                @method('PUT')
                                @csrf
                                <select
                                id="status"
                                name="status"
                                class="form-select form-control @error('status') is-invalid @enderror"
                                onchange="enableButton({{$candidature->id}});showInterviewInputs({{$candidature->id}});"
                                >
                                @foreach(\App\Enum\CandidatureStatusEnum::cases() as $option)
                                    <option
                                        value="{{$option->name}}"
                                        id="{{$option->name}}{{$candidature->id}}"
                                        @if ($option->value === \App\Enum\CandidatureStatusEnum::New->value)
                                            disabled
                                        @endif
                                        @if ($option->value === $candidature->status->value)
                                            disabled selected
                                        @endif
                                    >{{$option->value}}</option>
                                @endforeach
                            </select>
                                <div id="interview{{$candidature->id}}" style="display: none;">
                                    <input class="form-control" placeholder="invited emails seperated by ;" type="text" name="emails" id="emails">
                                    <input class="form-control @error('start_on') is-invalid @enderror" type="datetime-local" name="start_on">
                                    @error('start_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button id="button{{$candidature->id}}" type="submit" class="btn btn-outline-secondary" disabled>Change Status</button>
                            </form>
                            <hr>
                        @endforeach
                        <script>
                            function enableButton(x) {
                                document.getElementById('button'+x).disabled=false;
                            }

                            function showInterviewInputs(x) {
                                console.log(document.getElementById('Interview'+x).selected);
                                if (document.getElementById('Interview'+x).selected){
                                    document.getElementById('interview'+x).style.display="initial";
                                }else {
                                    document.getElementById('interview'+x).style.display="none";
                                }

                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
