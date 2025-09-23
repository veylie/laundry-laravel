<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransOrder;
use App\Models\TypeOfService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $statusMap = [0 => 'Pending', 1 => 'Pickup'];
        $orders = TransOrder::with('customer')->get()->map(function ($order) use ($statusMap) {
            return [
                'id' => $order->id,
                'code' => $order->order_code,
                'customer_name' => $order->customer->customer_name,
                'date' =>  Carbon::parse($order->order_date)->format('d F Y'),
                'date_end' =>  Carbon::parse($order->order_end_date)->format('d F Y'),
                'status' => $statusMap[$order->order_status] ?? 'unknown',
            ];
        });

        // return $orders;
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = Carbon::now()->format('dmY');
        $countDay = TransOrder::whereDate('created_at', now())->count() + 1;
        $runningNumber = str_pad($countDay, 3, '0', STR_PAD_LEFT);
        $code = 'TRS-' . $today . '-' . $runningNumber;
        $customers = Customer::all();
        $services = TypeOfService::all();

        $orders = TransOrder::with(['customer', 'details.service'])->orderBy('id', 'desc')->get();
        // return $customers;
        return view('orders.transaksi_form', compact('code', 'customers', 'services', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function newstore(Request $request)
    {
        return $request;
    }
}
