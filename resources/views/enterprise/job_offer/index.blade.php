@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">My Job Offers</div>

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
                        <div>
                            <form method="GET" action="{{route('jobOffer.create')}}">
                                <button class="btn btn-primary" type="submit">Create a Job Offer</button>
                            </form>
                        </div>
                        @if ($my_job_offers->count() > 0)
                            <table class="table">
                                    <tr>
                                        <th>title</th>
                                        <th>description</th>
                                        <th>city</th>
                                        <th>type</th>
                                        <th>degree</th>
                                        <th>number of positions</th>
                                        <th>visibility</th>
                                        <th>start on</th>
                                        <th>ends on</th>
                                        <th>show</th>
                                        <th>update</th>
                                        <th>delete</th>
                                    </tr>
                                    @foreach($my_job_offers as $offer)
                                        <tr>
                                            <td>{{$offer->title}}</td>
                                            <td>{{\Illuminate\Support\Str::limit($offer->description,50,'...')}}</td>
                                            <td>{{$offer->city}}</td>
                                            @if ($offer->type == null)
                                                <td></td>
                                            @else
                                                <td>{{$offer->type->value}}</td>
                                            @endif
                                            @if ($offer->degree == null)
                                                <td></td>
                                            @else
                                                <td>{{$offer->degree->value}}</td>
                                            @endif
                                            <td>{{$offer->number_of_positions}}</td>
                                            @if ($offer->visibility)
                                                <td>visible</td>
                                            @else
                                                <td>invisible</td>
                                            @endif

                                            <td>{{$offer->offer_start_on}}</td>
                                            <td>{{$offer->offer_ends_on}}</td>
                                            <td>
                                                <form method="GET" action="{{route('jobOffer.show',$offer)}}">
                                                    <button type="submit" class="btn"><i class="fa-solid fa-eye" style="color: blue;"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="GET" action="{{route('jobOffer.edit',$offer)}}">
                                                    <button type="submit" class="btn"><i class="fa-solid fa-pen-to-square" style="color: orange;"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{route('jobOffer.destroy',$offer)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn"><i class="fa-solid fa-trash" style="color: red;"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            {!! $my_job_offers->links() !!}
                        @else
                            <h5 class="alert text-center text-decoration-underline">You didn't create any job offer</h5>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
