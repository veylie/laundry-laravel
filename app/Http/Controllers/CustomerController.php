<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Pest\ArchPresets\Custom;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all()->map(function ($customer) {
            return [
                'id' => $customer->id,
                'customer_name' => $customer->customer_name,
                'phone' => $customer->phone,
                'address' => $customer->address
            ];
        });
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fullPhone = $request->phone_prefix . $request->phone_number;
        Customer::create([
            'customer_name' => $request->customer_name,
            'phone' => $fullPhone,
            'address' => $request->address
        ]);
        return redirect()->route('customers.index')->with('success', 'Data berhasil di tambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fullPhone = $request->phone_prefix . $request->phone_number;
        $customer = Customer::find($id);
        $customer->update([
            'customer_name' => $request->customer_name,
            'phone' => $fullPhone,
            'address' => $request->address
        ]);
        return redirect()->route('customers.index')->with('success', 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Data berhasil di hapus!');
    }
}
