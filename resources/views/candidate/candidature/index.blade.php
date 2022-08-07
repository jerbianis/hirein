@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                @foreach($candidatures as $candidature)
                @endforeach
                <div class="card">
                    <div class="card-header">Candidatures</div>

                    <div class="card-body">
                        @if ($candidatures->isNotEmpty())
                            <table class="table">
                                <tr>
                                    <th>offer title</th>
                                    <th>status</th>
                                    <th>delete</th>
                                </tr>
                                @foreach($candidatures as $candidature)
                                    <tr>
                                        <td>{{$candidature->job_offer->title}}</td>
                                        @if ($candidature->status == null)
                                            <td></td>
                                        @else
                                            <td>{{$candidature->status->value}}</td>
                                        @endif

                                        <td>
                                            <form method="POST" action="{{route('candidature.destroy',$candidature)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn"><i class="fa-solid fa-trash" style="color: red;"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $candidatures->links() !!}
                        @else
                            <h5 class="alert text-center text-decoration-underline">You didn't apply for job offer</h5>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
