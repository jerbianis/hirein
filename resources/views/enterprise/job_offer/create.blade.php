@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">My Job Offers</div>

                    <div class="card-body">
{{--                        <h2>{{$errors}}</h2>--}}
                        <form method="POST" action="{{route('jobOffer.store')}}">
                            @csrf

                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">Title<span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="title" type="text" placeholder="Title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Description<span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" required autofocus>{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="number_of_positions" class="col-md-4 col-form-label text-md-end">Number of Positions<span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="number_of_positions" type="number" class="form-control @error('number_of_positions') is-invalid @enderror" name="number_of_positions" min="1" value="1" autocomplete="number_of_positions" autofocus>

                                    @error('number_of_positions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" maxlength="25" placeholder="City" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" autocomplete="city" autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="type" class="col-md-4 col-form-label text-md-end">Offer Type</label>
                                <div class="col-md-6">
                                    <select
                                        id="type"
                                        name="type"
                                        class="form-select form-control @error('type') is-invalid @enderror"
                                    >
                                        <option value="" disabled selected>Offer Type</option>
                                        <?php use \App\Enum\OfferTypeEnum; ?>
                                        @foreach(OfferTypeEnum::cases() as $option)
                                            <option value="{{$option->name}}" >{{$option->value}}</option>
                                        @endforeach
                                    </select>

                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="degree" class="col-md-4 col-form-label text-md-end">Degree</label>
                                <div class="col-md-6">
                                    <select
                                        id="degree"
                                        name="degree"
                                        class="form-select form-control @error('degree') is-invalid @enderror"
                                    >
                                        <option value="" disabled selected>Degree</option>
                                        <?php use \App\Enum\DegreeTypeEnum; ?>
                                        @foreach(DegreeTypeEnum::cases() as $option)
                                            <option value="{{$option->name}}" >{{$option->value}}</option>
                                        @endforeach
                                    </select>

                                    @error('degree')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-3 form-check form-switch">
                                <label for="visibility" class="form-check-label">Visibility</label>
                                <input id="visibility" type="checkbox" class="form-control form-check-input" name="visibility" checked autofocus>
                            </div>

                            <div class="row mb-3">
                                <label for="offer_start_on" class="col-md-4 col-form-label text-md-end">Offer Start On<span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="offer_start_on" type="date" value="{{today()->format("Y-m-d")}}" min="{{today()->format("Y-m-d")}}" class="form-control @error('offer_start_on') is-invalid @enderror" name="offer_start_on" value="{{ old('offer_start_on') }}" autocomplete="offer_start_on" required autofocus>

                                    @error('offer_start_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="offer_ends_on" class="col-md-4 col-form-label text-md-end">Offer Ends On</label>

                                <div class="col-md-6">
                                    <input id="offer_ends_on" type="date" min="{{today()->format("Y-m-d")}}" class="form-control @error('offer_ends_on') is-invalid @enderror" name="offer_ends_on" value="{{ old('offer_ends_on') }}" autocomplete="offer_ends_on" autofocus>

                                    @error('offer_ends_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Create a Job Offer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

