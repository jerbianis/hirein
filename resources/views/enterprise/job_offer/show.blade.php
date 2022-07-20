@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">My Job Offer</div>

                    <div class="card-body">
                        <p>{{$jobOffer->title}}</p>
                        <p>{{$jobOffer->description}}</p>
                        <p>{{$jobOffer->city}}</p>
                        @if ($jobOffer->type == null)
                            <p></p>
                        @else
                            <p>{{$jobOffer->type->value}}</p>
                        @endif
                        @if ($jobOffer->degree == null)
                            <p></p>
                        @else
                            <p>{{$jobOffer->degree->value}}</p>
                        @endif
                        <p>{{$jobOffer->number_of_positions}}</p>
                        @if ($jobOffer->visibility)
                            <p>visible</p>
                        @else
                            <p>invisible</p>
                        @endif

                        <p>{{$jobOffer->offer_start_on}}</p>
                        <p>{{$jobOffer->offer_ends_on}}</p>

                        @if ($jobOffer->candidatures->count())
                            <form method="GET" action="{{route('jobOffer.candidatures.index',$jobOffer)}}">
                                <button type="submit" class="btn btn-outline-primary">{{$jobOffer->candidatures->count()}}</button>
                            </form>
                        @else
                            <button type="button" class="btn btn-outline-warning" disabled>{{$jobOffer->candidatures->count()}}</button>
                        @endif
                        <div>
                            <form method="GET" action="{{route('jobOffer.edit',$jobOffer)}}">
                                <button type="submit" class="btn"><i class="fa-solid fa-pen-to-square" style="color: orange;"></i></button>
                            </form>
                        </div>
                        <div>
                            <form method="POST" action="{{route('jobOffer.destroy',$jobOffer)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn"><i class="fa-solid fa-trash" style="color: red;"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
