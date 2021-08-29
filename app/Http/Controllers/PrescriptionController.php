<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescription;
use App\Mail\PrescriptionAssigned;
use App\Models\Appointment;
use App\Models\Drug;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $prescriptions = Prescription::paginate(9);
        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $patients = User::query()->role(1)->get();
        $drugs = Drug::all();
        return view('prescriptions.create', compact('patients', 'drugs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePrescription $request
     * @return Application|Factory|View|Response
     */
    public function store(StorePrescription $request)
    {
        $data = $request->input();
        $user = User::findOrFail($data['user_id']);

        $id = Prescription::create($data);
        if($id && $user){
            Mail::to($user)->send(new PrescriptionAssigned($id));
        }
        $prescriptions = Prescription::paginate(9);
        return view('prescriptions.index', compact('prescriptions'))->with('status', 'Prescription registered');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Prescription $prescription
     * @return RedirectResponse
     */
    public function destroy(Prescription $prescription)
    {
        $return_status = 'Prescription can be canceled until 1 hour after being created';
        if(strtotime($prescription->created_at. '+1 hour') >= strtotime(date('Y-m-d H:i:s'))){
            $prescription->delete();
            $return_status = 'Prescription canceled';
        }
        $prescriptions = Prescription::paginate(9);
        return redirect()->route('prescriptions.index', compact('prescriptions'))->with('status', $return_status);
    }
}
