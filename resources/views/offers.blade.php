@extends('layouts.app')

@section('content')


@if ($my_job_offers->isNotEmpty())



<div class="container">
    @foreach($my_job_offers as $offer)
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card mb-3" style="padding: 8px 16px" >
                <div class="row g-0">
                  <div class="col-md-2" style="display: grid; place-items: center" >
                        <img src="{{asset('storage/logo/'.$offer->enterprise->logo)}}"

                             style="width: 10rem;" alt="logo {{$offer->enterprise->name}}">
                    </div>
                  <div class="col-md-9">
                    <div class="card-body" style="padding: 0.3rem 1rem" >
                        <button class="btn" style="padding: 0"  ><h5 class="card-title" style="color: #0a66c2;font-weight: bold;font-size: 20px;" >{{$offer->title}}</h5></button>
                        <div style="display: flex;flex-direction:row;align-items:center;margin-top:-8px;" >

                            <div class="card-text" style="font-size: 12px;color:#6C757D" >

                                @if ($offer->city) {{$offer->city}} @endif

                              </div>&nbsp;&nbsp;
                              <div class="card-text"  style="font-size: 12px;color:#6C757D" >
                                  {{\Carbon\Carbon::create($offer->offer_start_on)->isoFormat('MMMM Do YYYY')}}
                              </div>
                        </div>

                      <div class="card-text" style="margin-bottom: 0;font-size: 18px" >{{$offer->enterprise->name}}</div>

                      <div class="card-text" style="font-size: 14px; margin: 8px 0" >
                        {{\Illuminate\Support\Str::limit($offer->description,300,'...')}}
                      </div>
                            @if($offer->number_of_positions)
                                <div class="card-text" style="font-size: 13px" >
                                    <i class="fa-solid fa-chair" style="color:#5f6163; font-size: 13px" ></i>
                                    {{$offer->number_of_positions}} @if($offer->number_of_positions > 1)
                                        Places
                                    @else
                                        Place
                                    @endif

                                </div>
                            @endif
                            @if($offer->type)
                                <div class="card-text" style="font-size: 13px" >
                                    <i class="fa-solid fa-file-signature" style="color:#5f6163; font-size: 13px" ></i>
                                    {{$offer->type->value}}

                                </div>
                            @endif
                            @if($offer->degree)
                                <div class="card-text" style="font-size: 13px" >
                                    <i class="fa-solid fa-graduation-cap" style="color:#5f6163; font-size: 13px" ></i>
                                      {{$offer->degree->value}} Degree

                                </div>
                            @endif

                            @if($offer->offer_ends_on)
                              <div class="card-text" style="font-size: 13px" >
                                <i class="fa-solid fa-business-time" style="color:#5f6163; font-size: 13px" ></i>
                                 Ends {{\Carbon\Carbon::create($offer->offer_ends_on)->isoFormat('MMMM Do YYYY')}}

                              </div>
                            @endif

                    </div>
                  </div>

                  <div class="col-md-1" style="display: grid; place-items: center" >
                    @guest()

                                            <form action="{{route('register')}}">
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                            </form>

                     @endguest
                    @auth
                    @if (auth()->user()->isCandidate())
                            <!-- Button trigger modal -->
                            <button type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{$offer->id}}"
                                    @if (in_array($offer->id,$job_offer_ids))
                                        disabled
                                    @endif
                            >Apply</button>
                    @endif
                @endauth
                  </div>
                </div>
            </div>
        </div>
    </div>


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

<div class="col-md-9;" >{!! $my_job_offers->links() !!}</div>


</div>




@else
    <h5 class="alert text-center text-decoration-underline">There is no job offer</h5>
@endif



@endsection
