<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        $request->validate([
            'picture'   =>  'file|image|required|mimes:jpeg,jpg,png|max:10240'
        ]);
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        if ($picture = $request->file('picture')) {

            $name = 'picture' .$candidate->id.'.jpg';
            $picture->storePubliclyAs('profile_pictures',$name,'public');
            $image = Image::make('storage/profile_pictures/'.$name);
            $image->orientate();
            $image->widen(500)->resizeCanvas(500,500)->encode('jpg')->save();
            $candidate->picture =$name;
            $candidate->save();
        }
        return back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function uploadCV(Request $request) {
        $request->validate([
            'CV_file'   =>  'file|required|mimes:pdf|max:5120'
        ]);
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        if ($cv = $request->file('CV_file')) {

            $name = 'CV' .$candidate->id.'_'.$candidate->name.'.pdf';
            $cv->storePubliclyAs('CV',$name,'public');

            $candidate->CV_file =$name;
            $candidate->save();
        }
        return back();

    }

    /**
     * @return \Illuminate\Http\Response
     *
     */
    public function deleteCV() {
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        if (Storage::exists('public/CV/'.$candidate->CV_file)) {
            Storage::delete('public/CV/'.$candidate->CV_file);
            $candidate->CV_file =null;
            $candidate->save();
        }

        return back();
    }

    /**
     * @return \Illuminate\Http\Response
     *
     */
    public function deletePicture() {
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        if (Storage::exists('public/profile_pictures/'.$candidate->picture) and $candidate->picture != "picture.jpg") {
            Storage::delete('public/profile_pictures/'.$candidate->picture);
            $candidate->picture ="picture.jpg";
            $candidate->save();
        }

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function updateCandidate(Request $request)
    {
        if ($request['is_open_for_job'] == 'on') {
            $request['is_open_for_job']= true;
        }else {
            $request['is_open_for_job']= false;
        }
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'birth_date'    => ['required','before:-16 years'],
            'job_title'     => ['nullable','string','min:3','max:30'],
            'profile_resume'=> ['nullable','string','min:20','max:65535'],
            'is_open_for_job'=> ['required','boolean'],
        ],[
            'birth_date.before'=>'Your age must be at least 16 years old.'
        ]);
        $user = Auth::user();
        $candidate = Candidate::find($user->profile->id);
        $candidate->update($request->all());
        $candidate->save();
        return back();
    }

}
