<?php

namespace App\Http\Controllers;

use App\Models\UserPrescription;
use Illuminate\Http\Request;

class OrderPrescriptoinController extends Controller
{
    public function index(Request $request){
        $date = $request->date;
        $sort_search = null;
        $orders = UserPrescription::with(['user', 'product'])->orderBy('id', 'desc');

        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        $prescriptions = $orders->paginate(15);
        return view('backend.sales.customer_prescription.index', compact('prescriptions', 'sort_search', 'date'));
    }

    public function show($id){
        return $id;
    }
}
