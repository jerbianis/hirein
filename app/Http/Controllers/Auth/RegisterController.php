<?php

namespace App\Http\Controllers\Auth;

use App\Enum\MainActivityEnum;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Enterprise;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required','in:candidate,enterprise'],
            'birth_date' => ['exclude_unless:role,candidate','required_if:role,candidate','before:-16 years'],
            'job_title' => ['exclude_unless:role,candidate','nullable','string','min:3','max:30'],
            'main_activity' => ['exclude_unless:role,enterprise','required_if:role,enterprise',Rule::in(MainActivityEnum::names())],
            'manager_name' => ['exclude_unless:role,enterprise','nullable','string','min:3','max:30']
        ],[
                'birth_date.before'=>'Your age must be at least 16 years old.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($data['role'] == 'candidate') {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $candidate = Candidate::create([
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'job_title' => $data['job_title']
            ]);
            $candidate->user()->save($user);
        }else if ($data['role'] == 'enterprise') {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->save();
            $enterprise = Enterprise::create([
                'name' => $data['name'],
                'main_activity' => MainActivityEnum::getValue($data['main_activity']),
                'manager_name' => $data['manager_name']
            ]);
            $enterprise->user()->save($user);
        }

        return $user;
    }
}
