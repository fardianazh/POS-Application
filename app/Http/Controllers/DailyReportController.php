<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Category;

class DailyReportController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $label_bar = ['Selling'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = 'rgba(60,141,188,0.9)';
            $data_month = [];

            foreach (range(1,12) as $month) {
                $data_month[] = Transaction::select(Transaction::raw("COUNT(*) as total"))->whereMonth('created_at', $month)->first()->total;
            }

            $data_bar[$key]['data'] = $data_month;
        }

        return view('admin.chartdaily', compact('data_bar'));
    }
}
