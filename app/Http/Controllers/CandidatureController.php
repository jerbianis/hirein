<?php

namespace App\Http\Controllers;

use App\Enum\CandidatureStatusEnum;
use App\Models\Candidature;
use App\Http\Requests\StoreCandidatureRequest;
use App\Http\Requests\UpdateCandidatureRequest;
use Illuminate\Support\Arr;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Candidature::class);
        $candidatures = Candidature::with('job_offer')->where('candidate_id',auth()->user()->profile->id)
            ->latest()
            ->paginate(5);
        return view('candidate.candidature.index',[
            'candidatures'  =>  $candidatures
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCandidatureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidatureRequest $request)
    {
        //
        $this->authorize('create', Candidature::class);
        $candidate = auth()->user()->profile;
        $candidatures = $candidate->candidatures;
        $job_offer_ids = Arr::pluck($candidatures,'job_offer_id');
        if (in_array($request->offer,$job_offer_ids)) {
            return redirect(route('candidature.index'));
        }else {
            $candidature = new Candidature();
            $candidature->job_offer_id = $request->offer;
            $candidature->status = CandidatureStatusEnum::New;
            $candidature->cover_letter = $request->cover_letter;
            $candidate->candidatures()->save($candidature);
            $request->session()->flash('status', 'Your Application Created Successfully');
            return redirect(route('offers'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function show(Candidature $candidature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidature $candidature)
    {
        //
        $this->authorize('delete', $candidature);
        if ($candidature->delete()) {
            request()->session()->flash('status-danger', 'Your Candidature Deleted Successfully');
        };

        return back();
    }
}
