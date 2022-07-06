<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use Illuminate\Validation\Rule;

class JobOfferController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(JobOffer::class,'jobOffer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $my_job_offers=JobOffer::where('enterprise_id',auth()->user()->profile->id)->paginate(5);
        return view('enterprise.job_offer.index',[
            'my_job_offers' => $my_job_offers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('enterprise.job_offer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobOfferRequest $request)
    {
        //
        if ($request['visibility'] == 'on') {
            $request['visibility']= true;
        }else {
            $request['visibility']= false;
        }
        $request->validate(
          ['visibility'    =>  ['required','boolean']]
        );

        $enterprise = auth()->user()->profile;
        $offer = new JobOffer($request->all());
        $enterprise->job_offers()->save($offer);
        $request->session()->flash('status', 'Job Offer Created Successfully');
        return redirect(route('jobOffer.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function show(JobOffer $jobOffer)
    {
        //
        return view('enterprise.job_offer.show', compact('jobOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOffer $jobOffer)
    {
        //
        return view('enterprise.job_offer.edit', compact('jobOffer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobOfferRequest  $request
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer)
    {
        //
        if ($request['visibility'] == 'on') {
            $request['visibility']= true;
        }else {
            $request['visibility']= false;
        }
        $request->validate(
            [
                'visibility'    =>  ['required','boolean'],
                'offer_start_on'=>  [['after_or_equal'=>$jobOffer->created_at]]
            ]);
        if ($jobOffer->update($request->all())) {
            $request->session()->flash('status-warning', 'Job Offer Updated Successfully');
        }
        return redirect(route('jobOffer.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $jobOffer)
    {
        //
        if ($jobOffer->delete()) {
            request()->session()->flash('status-danger', 'Job Offer Deleted Successfully');
        };
        return redirect(route('jobOffer.index'));

    }
}
