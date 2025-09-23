<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function getFilteredOrders(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        return TransOrder::with('customer', 'transOrderDetails.typeOfService', 'transLaundryPickups')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orWhereBetween('order_end_date', [$startDate, $endDate])
            ->get();
    }

    public function index(Request $request)
    {
        $orders = $this->getFilteredOrders($request);

        $totalRevenue = $orders->where('order_status', 1)->sum('total');
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('order_status', 1)->count();
        $pendingOrders = $orders->where('order_status', 0)->count();

        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        return view('reports.index', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'startDate',
            'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Ambil data dengan filter tanggal (custom sesuai kebutuhanmu)
        $orders = $this->getFilteredOrders($request);

        $pdf = PDF::loadView('reports.export_pdf', compact('orders'))->setPaper('a4', 'landscape'); // bisa portrait kalau mau

        $filename = 'laporan_penjualan_' . Carbon::now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $export = new OrdersExport($request->start_date, $request->end_date);
        $filename = 'laporan_penjualan_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        return Excel::download($export, $filename);
    }
}
