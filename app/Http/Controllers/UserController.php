<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
class UserController extends Controller
{

    // public function __construct(){
    //     // $this->middleware('Role:view');
    //     $this->middleware('Test');
    //  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    //  return view('user.index');
     return "<br>test from index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('form');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $response = new \Illuminate\Http\Response('Hello World');
        // // dd($response);
        // $response->withCookie(cookie('shahnavaz','peerbits',2));
        
        // return $response;

        dd($request->password,$request->username,$request->name);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "FAizan $id";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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

        $name = $request->input('username');
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
    }

    public function myfunction(Request $request){
        //Here am going to get the cookie

        dd($request->cookie('shahnavaz'));
        
        
    }

    public function Registration(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'username'=>'required|max:8',
            'password'=>'required|min:6',
        ]);

        // dd($request->email);
        $file = $request->file('image');
        $destination = '/upload/images/';

        $data = ['name'=>$request->username];
        Mail::send(['text'=>'mail'],$data,function($message) use($request,$destination){
            $message->to($request->get('email'))
            ->subject('Registration email')
            ->from('admin@abc.com')
            ->attach(base_path().$destination.'img.jpeg');
        });
        return dump('Mail has been sent please check your email box');
        // $file->move(base_path().$destination,$file->getClientOriginalName());
        // return dd($file->getMimeType());
        

    }
}
