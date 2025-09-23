<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransLaundryPickup;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $orders = TransOrder::with(['customer', 'transOrderDetails.typeOfService'])->orderBy('id', 'desc')->get();
        // return $customers;
        return view('orders.transaksi_form', compact('code', 'customers', 'services', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = TransOrder::with('customer')->where('id', $id)->first();
        $customer = $order->customer;
        $orderDetails = TransOrderDetail::with(['transOrder', 'typeOfService'])->where('id_order', $id)->get();
        // return $orderDetail;
        $orderDetail = $orderDetails->map(function ($orderDetail) {
            return [
                'id' => $orderDetail->id,
                'service' => $orderDetail->typeOfService->service_name,
                'qty' => $orderDetail->qty,
                'price' => 'Rp ' . number_format($orderDetail->typeOfService->price, 0, ',', '.'),
                'subtotal' => 'Rp ' . number_format($orderDetail->subtotal, 0, ',', '.'),
                'notes' => $orderDetail->notes
            ];
        });
        return view('orders.show', compact('orderDetail', 'order', 'customer'));
    }

    public function complete(Request $request, TransOrder $order)
    {
        $request->validate([
            'order_pay' => 'required|numeric|min:' . $order->total,
        ]);

        $order->order_pay = $request->order_pay;
        $order->order_change = $request->order_pay - $order->total;
        $order->order_status = 1; // misalnya 1 berarti selesai
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Transaksi diselesaikan.');
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
    public function destroy(string $id) {}

    public function newStore(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'customer.id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'total' => 'required|numeric',
            'order_date' => 'required|date',
            'order_status' => 'required|bool'
        ]);

        DB::beginTransaction();
        try {
            // Simpan Order
            $order = TransOrder::create([
                'order_code' => $request->id,
                'id_customer' => $request->customer['id'],
                'order_date' => Carbon::parse($request->order_date)->format('Y-m-d H:i:s'),
                'order_end_date' => Carbon::now()->addDays(3)->toDateString(),
                'order_status' => $request->order_status,
                'order_pay' => 0,
                'order_change' => 0,

                'total' => $request->total
            ]);

            // Simpan Detail Orders
            foreach ($request->items as $item) {
                TransOrderDetail::create([
                    'id_order' => $order->id,
                    'id_service' => $item['id_service'],
                    'qty' => $item['weight'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'notes' => $item['notes'] ?? null
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => $order->load('transOrderDetails.typeOfService', 'customer')
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menyimpan Transaksi',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getAllDataOrders()
    {
        $transactions = TransOrder::with(['customer', 'transOrderDetails.typeOfService'])->get();
        $data = $transactions->map(function ($trx) {
            return [
                'id' => $trx->order_code,
                'customer' => [
                    'id' => $trx->customer->id ?? null,
                    'name' => $trx->customer->customer_name ?? null,
                    'phone' => $trx->customer->phone ?? null,
                    'address' => $trx->customer->address ?? null,
                ],
                'items' => $trx->transOrderDetails->map(function ($orderDetail) {
                    return [
                        'id' => $orderDetail->id,
                        'service' => $orderDetail->typeOfService->service_name ?? null,
                        'weight' => $orderDetail->qty,
                        'price' => $orderDetail->typeOfService->price,
                        'subtotal' => $orderDetail->subtotal,
                        'notes' => $orderDetail->notes ?? null
                    ];
                }),
                'total' => $trx->total,
                'date' => $trx->order_date,
                'status' => $trx->getStatusTextAttribute(),
                'order_status' => $trx->order_status,
            ];
        });
        return response()->json($data);
    }

    public function pickupLaundry(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:0,1' // misalnya ada banyak status
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $order = TransOrder::where('order_code', $id)->firstOrFail();

                $order->update([
                    'order_pay' => $order->total,
                    'order_status' => $request->order_status,
                    // 'order_end_date' => Carbon::now()->toDateString()
                ]);

                if ($request->order_status == 1) {
                    TransLaundryPickup::create([
                        'id_order' => $order->id,
                        'id_customer' => $order->id_customer,
                        'pickup_date' => Carbon::now(),
                        'notes' => $request->notes ?? '',
                    ]);
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Status berhasil diupdate',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Error' . $th->getMessage(),
            ], 500);
        }
    }

    public function print(string $id)
    {
        try {
            $order = TransOrder::with(['customer', 'transOrderDetails.typeOfService'])
                ->findOrFail($id);

            session()->reflash();

            return view('orders.print', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')->with('error_message', 'Gagal memuat struk: ' . $e->getMessage());
        }
    }
}
