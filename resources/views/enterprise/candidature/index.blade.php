@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{$jobOffer->title}}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('status-warning'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('status-warning') }}
                            </div>
                        @endif
                        @if (session('status-danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status-danger') }}
                            </div>
                        @endif
                        @if ($can_reject_the_rest)
                            <form method="POST" action="{{route('jobOffer.candidatures.reject_the_rest',$jobOffer)}}">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject the rest</button>
                            </form>
                        @endif

                        @foreach ($candidatures as $candidature)
                            {{$candidature}}
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
                                    <input type="text" name="emails">
                                    <input type="datetime-local" name="start_on">
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
