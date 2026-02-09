<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class InfoUserController extends Controller
{
    public $positions = [
        "DOCUMENT CONTROLLER",
        "ASSISTANT DOCUMENT CONTROLLER",
        "TECHNICAL SUPERINTENDENT",
        "SENIOR EXECUTIVE TECHNICAL",
        "EXECUTIVE OPERATION",
        "JUNIOR EXECUTIVE TECHNICAL",
        "SENIOR EXECUTIVE CUM HSE",
        "MARINE SUPRINTENDENT",
        "CHIEF EXECUTIVE OFFICER",
        "HOD PROCUREMENT",
        "EXECUTIVE PROCUREMENT"
    ];

    public $roles = [
      "admin"=>"ADMIN",
      "staff"=>"STAFF",
      "hod"=>"HEAD OF DEPARTMENT",
    ];

    public $departments = [
        "TECHNICAL",
        "OPERATION",
        "PROCUREMENT"
    ];

    public $companies = [
      "Aims-Global Ship Management Sdn Bhd (AGSHIM)",
      "Aims-Global Engineering Sdn Bhd (AGESB)"
    ];

    public function index(){
        $users = User::all();

        return view('user.index', compact('users'));
    }


    public function create()
    {
        return view('user.create', [
            'positions'=>$this->positions,
            'roles'=>$this->roles,
            'departments'=>$this->departments,
            'companies'=>$this->companies
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'staff_no' => ['required'],
            'noic'=> ['required'],
            'phone'=> ['required'],
            'address'=>['required'],
            'position'=>['required'],
            'role'=>['required'],
            'department'=>['required'],
            'company'=>['required'],
            'marital'=>['required'],
            'gender'=>['required']
        ]);

        //Default password is IC
        $password = bcrypt($attributes['noic'] );

        User::create([
            'name'=>$attributes['name'],
            'email'=>$attributes['email'],
            'staff_no'=>$attributes['staff_no'],
            'noic'=>$attributes['noic'],
            'phone'=>$attributes['phone'],
            'address'=>$attributes['address'],
            'position'=>$attributes['position'],
            'role'=>$attributes['role'],
            'company'=>$attributes['company'],
            'department'=>$attributes['department'],
            'marital'=>$attributes['marital'],
            'gender'=>$attributes['gender'],
            'password'=>$password,
            'status'=>'ACTIVE'
        ]);

        return redirect()->route('user.index')->with('success','Successfully created new user');
    }

    public function show(User $user){
        return view('user.show', compact('user'));
    }

    public function profile(){
        $user = Auth::user();

        return view('user.profile', [
            'user'=>$user,
            'positions'=>$this->positions,
            'companies'=>$this->companies,
            'departments'=>$this->departments
        ]);
    }

    public function updateProfile(Request $request){
        $attributes = request()->validate(
            [
                'staff_no'=>'string',
                'noic'=>'string',
                'name'=>'string',
                'phone'=>'string',
                'email'=>'string',
                'address'=>'string',
                'position'=>'string',
                'department'=>'string',
                'company'=>'string',
                'marital'=>'string',
                'gender'=>'string'
            ]
        );

        $user=auth()->user();

        $user->update([
            'staff_no'=>$attributes['staff_no'],
            'noic'=>$attributes['noic'],
            'name'=>$attributes['name'],
            'phone'=>$attributes['phone'],
            'email'=>$attributes['email'],
            'address'=>$attributes['address'],
            'position'=>$attributes['position'],
            'department'=>$attributes['department'],
            'company'=>$attributes['company'],
            'marital'=>$attributes['marital'],
            'gender'=>$attributes['gender']
        ]);

        return redirect()->route('user.profile')->with('success','Successfully update your profile');
    }
}
