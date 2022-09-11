<?php

namespace App\Http\Controllers;

use App\Enum\CandidatureStatusEnum;
use App\Models\Candidate;
use App\Models\Candidature;
use App\Models\Enterprise;
use App\Models\Interview;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $joboffersids = JobOffer::without('enterprise')
            ->where('enterprise_id', auth()->user()->profile_id)->get('id');
        $candidaturesids=Candidature::where('status',CandidatureStatusEnum::Interview)
            ->whereIn('job_offer_id',$joboffersids->toArray())->get('id');
        $interviews = Interview::with('candidature')
            ->whereIn('candidature_id',\Arr::pluck($candidaturesids->toArray(),'id') )
            ->orderBy('start_on', 'asc')
            ->get();

        return view('enterprise.interviews',[
            'interviews'    =>  $interviews
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function interview(Request $request, Interview $interview)
    {
        //
        $token = $request->get('token');
        $secret = ENV('secretkey');
        $generatedToken = substr(sha1($secret . $interview->id), 0, 8);
        $candidature = Candidature::find($interview->candidature_id);
        $offer = JobOffer::find($candidature->job_offer_id);
        $candidate = Candidate::find($candidature->candidate_id);
        $positionName = 'Interview for '.$offer->title;
        $userName = $candidate->name;

        if ($generatedToken !== $token) {

            echo "Invalid interview access, try with: " . $generatedToken;
            abort(403,'Invalid interview access');
        }

        return view('interview', ['positionName' => $positionName, 'userName' => $userName]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interview $interview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interview $interview)
    {
        //
    }
}
