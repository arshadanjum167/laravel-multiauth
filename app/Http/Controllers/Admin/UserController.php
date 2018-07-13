<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query=User::where([
                            ['is_active','Y'],
                            ['is_deleted','N'],
                            ['isAdmin','<>','1']
                          ]);
        if ($request->has('search')) {
            
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orwhere('email', 'LIKE', '%' . $request->input('search') . '%');
            });
        }
        
        $user=$query->orderBy('id', 'desc')->paginate(5);
        return view('admin.user.index',['users'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules= [
              'name' => 'required|max:255|min:3',
              'email' => 'required|email|max:255|min:3',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
               return redirect('admin/user/create')
                           ->withErrors($validator)
                           ->withInput();
        }
        $user=new User;
        $user->name=$request->input('name');
        $user->email=$request->input('email');

        if($user->save())
        {
          $message=config('params.msg_success').'User successfully created !'.config('params.msg_end');
          $request->session()->flash('message',$message);
          return redirect('admin/user');
        }
        else {
          $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
          $request->session()->flash('message',$message);
          return redirect('admin/user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=User::find($id);
        if(!$user)
        {
          $message=config('params.msg_error').'user not found !'.config('params.msg_end');

          Session::flash('message',$message);
          return redirect('admin/user');
        }
        return view('admin.user.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules= [
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|max:255|min:3',
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('admin/user/'.$id.'/edit')
                         ->withErrors($validator)
                         ->withInput();
      }
      $user=User::find($id);

      if(!$user)
      {
        $message=config('params.msg_error').'User not found !'.config('params.msg_end');

        Session::flash('message',$message);
        return redirect('admin/user');
      }
      $user->name=$request->input('name');
      $user->email=$request->input('email');

      if($user->save())
      {
        $message=config('params.msg_success').'User successfully updated !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('admin/user');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('admin/user');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $halka=User::find($id);

      if(!$halka)
      {
        $message=config('params.msg_error').'User not found !'.config('params.msg_end');

        Session::flash('message',$message);
        return redirect('admin/user');
      }

      $halka->is_deleted='Y';

      if($halka->save())
      {
        $message=config('params.msg_success').'User successfully deleted !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('admin/user');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('admin/user');
      }
    }
}
