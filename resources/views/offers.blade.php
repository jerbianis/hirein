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
                                                <form action="{{route('register')}}">
                                                <button type="submit" class="btn btn-primary">Apply</button>
                                                </form>
                                            </td>
                                        @endguest
                                        @auth
                                            @if (auth()->user()->isCandidate())

                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                            class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{$offer->id}}"
                                                            @if (in_array($offer->id,$job_offer_ids))
                                                                disabled
                                                            @endif
                                                    >Apply</button>
                                                </td>

                                            @endif
                                        @endauth

                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$offer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$offer->id}}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <form method="POST" action="{{route('candidature.store')}}">
                                                    @csrf
                                                    <input type="hidden" name="offer" value="{{$offer->id}}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel{{$offer->id}}">Cover Letter</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                                <textarea id="cover_letter{{$offer->id}}" class="form-control @error('cover_letter') is-invalid @enderror" name="cover_letter" autocomplete="cover_letter" autofocus>{{ old('cover_letter') }}</textarea>
                                                                @error('cover_letter')
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
