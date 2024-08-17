<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagementUsersRequest;
use App\Http\Requests\UpdateManagementUsersRequest;
use App\Http\Requests\UpdateManagementUpdatePasswordRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class ManagementUsersController extends Controller
{
    protected mixed $user;
    public function __construct()
    {
       $this->user= auth()->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with('roles')->get();

        return view('mgmtusr.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('description', 'id');

        return view('mgmtusr.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManagementUsersRequest $request)
    {
        $user = User::create($request->validated());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('mgmtusr.index');
    }

    /**
     * Display the specified resource.
     */

    public function show($userId)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        $user = User::where('id', $userId)->first();
        $user = User::where('id', $userId)->first();
        //$roles=$user->roles();
        $roles=$user->getRoleNames();
        $permissions = $user->getAllPermissions();
        //dd($permissions);
        return view('mgmtusr.show', compact('user','roles','permissions'));
    }

    public function edit($userId)
    {
        abort_if(!$this->user->can('recipes-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Log::debug('can '.print_r($this->user->can('recipes-edit'),true));
        //Log::debug('can '.print_r($user->can('recipes-edit')));

        $user = User::where('id', $userId)->first();
        $roles = Role::all();
        $rolCurrent=$user->getRoleNames();

        return view('mgmtusr.edit', compact('user', 'roles','rolCurrent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManagementUsersRequest $request, $userId)
    {
        dd($userId);

        $user->update($request->validated());

        //$user->roles()->sync($request->input('roles', []));

        return redirect()->route('mgmtusr.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return redirect()->route('mgmtusr.index');
    }


    public function editpassword($userId)
    {
        abort_if(!$this->user->can('recipes-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Log::debug('can '.print_r($this->user->can('recipes-edit'),true));
        //Log::debug('can '.print_r($user->can('recipes-edit')));

        $user = User::where('id', $userId)->first();
        $passwordGenerated=$this->generateStrongPassword();

        return view('mgmtusr.update-password-form', compact('user','passwordGenerated'));
    }

    public function updatepassword(UpdateManagementUpdatePasswordRequest $request)
    {
        $userId = $request->input('id');

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ]);


        if ($validator->fails()) {
            return redirect()->route('mgmtusr.edtpwd', $userId)
                ->withErrors($validator)
                ->withInput();
        }

        // Retrieve the validated input...
        $validated = $validator->validated();

        // Retrieve a portion of the validated input...
        $password = $validator->safe()->input('password');
        //$password = $validator->safe()->only(['password']);
        //$validated = $validator->safe()->except(['name', 'email']);

        if($request->input('password')) {
            $user = User::where('id', $userId)->first();
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }

        return redirect()->route('mgmtusr.index');
    }
    protected function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        if(!$add_dashes)
            return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }


}
