<?php

namespace App\Http\Controllers;

use Validator;
use App\Contact;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{

    protected $rules = [
        'name' => 'required|min:3',
        'phone' => 'requuired|max:15',
        'email' => 'required|email',
        'message' => 'required|max:255'
    ];

    protected $messages = [
        'name.required' => 'Nama harus disi',
        'name.min' => 'Nama minimal 3 karakter',
        'phone.required' => 'No telepon harus diisi',
        'email.required' => 'Email harus diisi',
        'email.email' => 'Silahkan masukan email yang valid',
        'message.required' => 'Pesan tidak boleh kosong',
        'message.max' => 'Pesan tidak boleh melebihi 255 karakter'
    ];

    /**
     * Show the about page
     * 
     * @return \Illuminate\Http\Response
     */
    public function showAbout()
    {
        return view('tokostar.about');
    }

    /**
     * Show the contact form
     * 
     * @return \Illuminate\Http\Response
     */
    public function getContact()
    {
        return view('tokostar.contact');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response          
     */
    public function postContact(Request $request)
    {
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fail()) {
            return redirect('/contact')
                        ->withError($validator)
                        ->withInput();
        }

        Contact::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
        ]);

        Session::flash('Pesan Berhasil dikirim');

        return redirect('/contact');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
}
