<?php

namespace App\Http\Controllers;

use App\Enum\CandidatureStatusEnum;
use App\Http\Requests\UpdateCandidatureRequest;
use App\Models\Candidature;
use App\Models\JobOffer;

class ManageCandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function index(JobOffer $jobOffer)
    {
        //
        $this->authorize('viewAnyEnterprise', [Candidature::class,$jobOffer]);
        $candidatures = Candidature::with('candidate')->where('job_offer_id',$jobOffer->id)->paginate(5);

        $accepted=Candidature::where('job_offer_id',$jobOffer->id)->where('status',CandidatureStatusEnum::Accepted->value)->get()->count();
        $rejected=Candidature::where('job_offer_id',$jobOffer->id)->where('status',CandidatureStatusEnum::Rejected->value)->get()->count();
        $offer_is_done = ($accepted + $rejected) != Candidature::where('job_offer_id', $jobOffer->id)->get()->count();
        if ($jobOffer->number_of_positions == $accepted and $offer_is_done) {
            $can_reject_the_rest = true;
        }else {
            $can_reject_the_rest = false;
        }
        return view('enterprise.candidature.index',[
            'candidatures'  =>  $candidatures,
            'jobOffer'  =>  $jobOffer,
            'can_reject_the_rest'   =>  $can_reject_the_rest
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function show(JobOffer $jobOffer, Candidature $candidature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function edit(JobOffer $jobOffer, Candidature $candidature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobOffer  $jobOffer
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCandidatureRequest $request, JobOffer $jobOffer, Candidature $candidature)
    {
        //
        $this->authorize('update', [Candidature::class,$candidature]);
        if ($candidature->update(['status'=> $request->status])) {
            $request->session()->flash('status', 'Status Changed Successfully');
        }

        $accepted=Candidature::where('job_offer_id',$jobOffer->id)->where('status',CandidatureStatusEnum::Accepted->value)->get()->count();
        if ($request->status == CandidatureStatusEnum::Accepted->value and $jobOffer->number_of_positions == $accepted) {
            if ($jobOffer->update(['visibility' => false])) {
                $request->session()->flash('status-warning', 'You accepted the limit of the offer positions. Offer set to invisible.');
            }
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobOffer  $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function reject_the_rest(JobOffer $jobOffer)
    {
        //
        $this->authorize('reject_the_rest', $jobOffer);
        Candidature::where('job_offer_id',$jobOffer->id)
            ->where('status','!=',CandidatureStatusEnum::Accepted->name)
            ->update(['status'  =>  CandidatureStatusEnum::Rejected->name]);
        request()->session()->flash('status-warning', 'The rest of candidatures are rejected');
        return back();
    }
}
