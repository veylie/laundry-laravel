<?php

namespace App\Http\Controllers;

use App\Models\TypeOfService;
use Illuminate\Http\Request;

class TypeOfServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = TypeOfService::all()->map(function ($service) {
            return [
                'id' => $service->id,
                'service_name' => $service->service_name,
                'price' => $service->price,
                'description' => $service->description
            ];
        });
        return view('type_of_services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     return view('type_of_services.create');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        TypeOfService::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description
        ]);
        return redirect()->route('type_of_services.index')->with('success', 'Data berhasil di tambah!');
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
        $service = TypeOfService::find($id);
        return view('type_of_services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = TypeOfService::find($id);
        $service->update([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description
        ]);
        return redirect()->route('type_of_services.index')->with('success', 'Data berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = TypeOfService::find($id);
        $service->delete();
        return redirect()->route('type_of_services.index')->with('success', 'Data berhasil di hapus!');
    }
}
