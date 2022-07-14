@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Job Offers</div>

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

                        @if ($my_job_offers->isNotEmpty())
                            <table class="table">
                                <tr>
                                    <th>enterprise</th>
                                    <th>title</th>
                                    <th>description</th>
                                    <th>city</th>
                                    <th>type</th>
                                    <th>degree</th>
                                    <th>number of positions</th>
                                    <th>start on</th>
                                    <th>ends on</th>
                                    <th>show</th>
                                    @guest()
                                        <th>Apply</th>
                                    @endguest
                                    @auth()
                                        @if (auth()->user()->isCandidate())
                                            <th>Apply</th>
                                        @endif
                                    @endauth


                                </tr>
                                @foreach($my_job_offers as $offer)
                                    <tr>
                                        <td>{{$offer->enterprise->name}}</td>
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
                                        <td>{{$offer->offer_start_on}}</td>
                                        <td>{{$offer->offer_ends_on}}</td>
                                        <td>
                                            <form method="GET" action="">
                                                <button type="submit" class="btn"><i class="fa-solid fa-eye" style="color: blue;"></i></button>
                                            </form>
                                        </td>
                                        @guest()
                                            <td>
                                                <form method="GET" action="">
                                                    <button type="submit" class="btn btn-primary">Apply</button>
                                                </form>
                                            </td>
                                        @endguest
                                        @auth
                                            @if (auth()->user()->isCandidate())
                                                <td>
                                                    <form method="GET" action="">
                                                        <button type="submit" class="btn btn-primary">Apply</button>
                                                    </form>
                                                </td>
                                            @endif
                                        @endauth





                                    </tr>
                                @endforeach
                            </table>
                            {!! $my_job_offers->links() !!}
                        @else
                            <h5 class="alert text-center text-decoration-underline">There is no job offer</h5>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
