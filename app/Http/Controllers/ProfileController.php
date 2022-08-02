<?php

namespace App\Http\Controllers;

use App\Enum\MainActivityEnum;
use App\Models\Candidate;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function uploadLogo(Request $request) {
        $request->validate([
            'logo'   =>  'file|image|required|mimes:jpeg,jpg,png|max:10240'
        ]);
        $user = Auth::user();
        $enterprise = Enterprise::find($user->profile->id);
        if ($logo = $request->file('logo')) {
            $name = 'logo' .$enterprise->id.'.jpg';
            $logo->storePubliclyAs('logo',$name,'public');
            $image = Image::make('storage/logo/'.$name);
            $image->orientate();
            $image->widen(500)->resizeCanvas(500,500)->encode('jpg')->save();
            $enterprise->logo =$name;
            $enterprise->save();
        }
        return back();

    }

    /**
     * @return \Illuminate\Http\Response
     *
     */
    public function deleteLogo() {
        $user = Auth::user();
        $enterprise = Enterprise::find($user->profile->id);
        if (Storage::exists('public/logo/'.$enterprise->logo) and $enterprise->logo != "logo.jpg") {
            Storage::delete('public/logo/'.$enterprise->logo);
            $enterprise->logo ="logo.jpg";
            $enterprise->save();
        }

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function updateEnterprise(Request $request)
    {
        $user = Auth::user();
        $enterprise = Enterprise::find($user->profile->id);

        if ($request['is_open_for_hiring'] == 'on') {
            $request['is_open_for_hiring']= true;
        }else {
            $request['is_open_for_hiring']= false;
        }
        if ($request['main_activity']==null) {
            $request['main_activity']= $enterprise->main_activity->name;
        }
        $request['main_activity'] = MainActivityEnum::getValue($request['main_activity']);
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'main_activity'    => ['required',new Enum(MainActivityEnum::class)],
            'manager_name'     => ['nullable','string','min:3','max:30'],
            'description'=> ['nullable','string','min:20','max:65535'],
            'is_open_for_hiring'=> ['required','boolean'],
        ]);

        $enterprise->update($request->all());
        $enterprise->save();
        return back();
    }
}
