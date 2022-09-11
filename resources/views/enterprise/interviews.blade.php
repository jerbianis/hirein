@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Interviews</div>

                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th scope="col">Interview Date</th>
                                <th scope="col">Job Offer</th>
                                <th scope="col">Candidate Name</th>
                                <th scope="col">Interview URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($interviews as $interview)
                            <tr>
                                <td>{{$interview->start_on}}</td>
                                <td>{{$interview->candidature->job_offer->title}}</td>
                                <td>{{$interview->candidature->candidate->name}}</td>
                                <td><a href="{{$interview->interviewURL()}}" target="_blank">{{$interview->interviewURL()}}</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
