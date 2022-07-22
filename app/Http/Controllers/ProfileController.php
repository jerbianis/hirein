<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Candidature;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    /**
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {

    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        if ($user->isEnterprise()) {
            $enterprise = Enterprise::find($user->profile->id);
            return view('enterprise.edit_profile',[
                'enterprise' => $enterprise,
            ]);
        }
        if ($user->isCandidate()) {
            $candidate = Candidate::find($user->profile->id);
            return view('candidate.edit_profile', [
                'candidate' => $candidate,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function uploadpicture(Request $request) {
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        if ($picture = $request->file('picture')) {
            $name = 'picture' .$candidate->id.'.'.$picture->extension();
            $picture->storePubliclyAs('profile_pictures',$name,'public');
            $candidate->picture =$name;
            $candidate->save();
        }
        return back();

    }

    public function update()
    {

    }

}
