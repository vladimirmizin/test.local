<?php

namespace App\Http\Controllers\Auth;

use App\Models\Comment;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function getCountries()
    {
        $countries = Country::all();
        return view('auth/register', ['countries' => $countries]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function getRegions(Request $request)
    {
        $country_id = Region::where($request->get('country_id'), 'country_id')->get();
        dd($request->get('country_id'));

        if ($regs) {
            $num = mysql_num_rows($regs);
            $i = 0;
            while ($i < $num) {
                $regions[$i] = mysql_fetch_assoc($regs);
                $i++;
            }
            $result = array('regions' => $regions);
        } else {
            $result = array('type' => 'error');
        }
        print json_encode($result);

    }

    protected function getCity(Request $request, $region_id)
    {

    }
}
