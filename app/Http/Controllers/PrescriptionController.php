<?php

namespace App\Http\Controllers;

use App\Mail\PrescriptionAssigned;
use App\Models\Appointment;
use App\Models\Drug;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $prescriptions = Prescription::prescriptions();
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $patients = User::where('role', 1)->get();
        $drugs = Drug::all();
        return view('prescriptions.create', compact('patients', 'drugs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'user_id' => 'required|integer',
            'drug_id' => 'required|integer',
            'valid_until' => 'required|String',
        ]);

        $user = User::findOrFail($data['user_id']);

        $id = Prescription::create($data);
        if($id && $user){
            Mail::to($user)->send(new PrescriptionAssigned($id));
        }
        $prescriptions = Prescription::prescriptions();
        return view('prescriptions.index', compact('prescriptions'))->with('status', 'Prescription registered');
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $return_status = 'Prescription can be canceled until 1 hour after being created';
        if(strtotime($prescription->created_at. '+1 hour') >= strtotime(date('Y-m-d H:i:s'))){
            $prescription->delete();
            $return_status = 'Prescription canceled';
        }
        $prescriptions = Prescription::prescriptions();
        return redirect()->route('prescriptions.index', compact('prescriptions'))->with('status', $return_status);
    }
}
