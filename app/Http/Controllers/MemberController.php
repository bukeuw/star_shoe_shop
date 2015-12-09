<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Contact;
use App\Profile;
use App\Transaction;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{

    protected $rules = [
        'contact' => [
            'name' => 'required|min:3',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required|max:255'
        ],
        'profile' => [
            'full_name' => 'required|min:3',
            'phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required|digits:5',
        ]
    ];

    protected $messages = [
        'contact' => [
            'name.required' => 'Nama harus disi',
            'name.min' => 'Nama minimal 3 karakter',
            'phone.required' => 'No telepon harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Silahkan masukan email yang valid',
            'message.required' => 'Pesan tidak boleh kosong',
            'message.max' => 'Pesan tidak boleh melebihi 255 karakter'
        ],
        'profile' => [
            'full_name.required' => 'Nama lengkap harus diisi',
            'full_name.min' => 'Nama lengkap tidak boleh kurang dari 3 huruf',
            'phone_number.required' => 'No Telepon harus diisi',
            'address.required' => 'Alamat harus diisi',
            'city.required' => 'Nama kota harus diisi',
            'province.required' => 'Nama provinsi harus diisi',
            'postal_code.required' => 'Kode pos harus diisi',
            'postal_code.digits' => 'Kode pos hanya boleh diisi dengan angka',
            'postal_code.max' => 'Kode pos tidak valid'
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['showAbout', 'getContact', 'postContact']]);
    }

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
        $validator = Validator::make($request->all(), $this->rules['contact'], $this->messages['contact']);

        if($validator->fails()) {
            return redirect('/contact')
                        ->withErrors($validator)
                        ->withInput();
        }

        Contact::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
        ]);

        \Session::flash('message', 'Pesan Berhasil dikirim');

        return redirect('/contact');
    }

    public function getProfile()
    {
        $actions = 'Simpan';
        $submitTo = '/member/profile';

        if(Auth::user()->profile) {
            $actions = 'Update';
            $submitTo = '/member/profile/' . Auth::user()->profile->id;
            $profile = Auth::user()->profile;
            
            return view('tokostar.profile', compact('actions', 'submitTo', 'profile'));
        }

        return view('tokostar.profile', compact('actions', 'submitTo'));
    }

    public function postProfile(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules['profile'], $this->messages['profile']);

        if($validator->fails()) {
            return redirect('/member/profile')
                        ->withErrors($validator)
                        ->withInput();
        }

        Auth::user()->profile()->create($request->all());

        if(\Session::has('needProfile')) {
            \Session::forget('needProfile');
            return redirect('/cart/checkout');
        }

        return redirect('/member/profile');
    }

    public function updateProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->rules['profile'], $this->messages['profile']);

        if($validator->fails()) {
            return redirect('/member/profile')
                        ->withError($validator)
                        ->withInput();
        }

        $profile = Profile::findOrFail($id);

        $profile->update($request->all());

        return redirect('/member/profile');
    }

    public function getTransactionList()
    {
        return view('tokostar.transaction');
    }

    public function getTransactionDetail($id)
    {
        $transaction = Transaction::findOrFail($id);

        return view('tokostar.transactiondetail', compact('transaction'));
    }

    public function downloadTransactionPDF($id)
    {
        $transaction = Transaction::findOrFail($id);
        $pdf = \PDF::loadView('tokostar.transactionreceipt', compact('transaction'));

        return $pdf->download('invoice.pdf');
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
