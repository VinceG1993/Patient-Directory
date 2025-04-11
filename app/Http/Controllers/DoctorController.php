<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('doctors.index', compact('users'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:42',
            'email' => 'required|email|max:42|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'clinic_address' => 'required|string|max:255',
            'deposit_required' => 'required|boolean',
            'password' => 'required|string|min:6',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'clinic_address' => $request->clinic_address,
            'deposit_required' => $request->deposit_required,
            'password' => bcrypt($request->password),
        ]);
    
        return redirect()->back()->with('success', 'New doctor added successfully!');
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(User $user)
    {
        return view('doctors.edit', compact('user'));
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:42',
            'email' => 'required|email|max:42|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:15',
            'clinic_address' => 'required|string|max:255',
            'deposit_required' => 'required|boolean',
        ]);
    
        $user->update($request->all());
    
        return redirect()->back()->with('success', 'Doctor updated successfully!');
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    public function showAppointments($id)
    {
        $user = User::findOrFail($id);
        $records = $user->appointments;

        return view('doctors.appointments', compact('user', 'records'));
    }
}
