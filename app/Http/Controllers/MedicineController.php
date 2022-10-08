<?php

namespace App\Http\Controllers;

use App\Category;
use App\Models\Medicine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $products = Medicine::orderBy('id','desc')->paginate(15);
        return view('backend.product.products.index', compact('products'));
    }

    public function create()
    {
        $generics = Medicine::select('generic')->get()->groupBy('generic');
        $cNames = Medicine::select('c_name')->get()->groupBy('c_name');
        $types = Medicine::select('type')->get()->groupBy('type');
        $categories = Category::all();
        return view('backend.product.products.create', compact('generics', 'categories', 'cNames', 'types'));
    }

    public function store(Request $request):RedirectResponse
    {
        Medicine::create([
            'name'                      => $request->name,
            'type'                      => $request->type,
            'generic'                   => $request->generic,
            'weight'                    => $request->weight,
            'c_name'                    => $request->c_name,
            'category_id'               => $request->category_id,
            'single_price'              => "৳".$request->single_price,
            'pack_Price'                => "৳".$request->pack_Price,
            'discount'                  => $request->discount,
            'discount_type'             => $request->discount_type,
            'photo'                     => $request->photos,
            'interaction'               => $request->interaction,
            'pharmacology'              => $request->pharmacology,
            'dosage_administration'     => $request->dosage_administration,
            'contraindications'         => $request->contraindications,
            'side_Effects'              => $request->side_Effects,
            'pregnancy_and_Lactation'   => $request->pregnancy_and_Lactation,
            'therapeutic'               => $request->therapeutic,
            'storage_conditions'        => $request->storage_conditions,
            'publication_status'        => $request->button == "unpublish" ? 0 : 1,
            'fetured_status'            => 0

        ]);
        flash(translate('Product has been inserted successfully'))->success();
        return redirect()->route('medicine.index');
    }

    public function edit($id)
    {

        $generics = Medicine::select('generic')->get()->groupBy('generic');
        $cNames = Medicine::select('c_name')->get()->groupBy('c_name');
        $types = Medicine::select('type')->get()->groupBy('type');
        $categories = Category::all();
        $medicine = Medicine::findOrFail($id);
        return view('backend.product.products.edit_medicine', compact('generics', 'categories', 'cNames', 'types', 'medicine'));
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update([
            'name'                      => $request->name,
            'type'                      => $request->type,
            'generic'                   => $request->generic,
            'weight'                    => $request->weight,
            'c_name'                    => $request->c_name,
            'category_id'               => $request->category_id,
            'single_price'              => "৳".$request->single_price,
            'pack_Price'                => "৳".$request->pack_Price,
            'discount'                  => $request->discount,
            'discount_type'             => $request->discount_type,
            'photo'                     => $request->photos,
            'interaction'               => $request->interaction,
            'pharmacology'              => $request->pharmacology,
            'dosage_administration'     => $request->dosage_administration,
            'contraindications'         => $request->contraindications,
            'side_Effects'              => $request->side_Effects,
            'pregnancy_and_Lactation'   => $request->pregnancy_and_Lactation,
            'therapeutic'               => $request->therapeutic,
            'storage_conditions'        => $request->storage_conditions,
            'publication_status'        => $request->button == "unpublish" ? 0 : 1,
            'fetured_status'            => 0
        ]);
        flash(translate('Product has been updated successfully'))->success();
        return redirect()->route('medicine.index');
    }

    public function delete($id)
    {
        $medicine = Medicine::findOrFail($id)->delete();
        flash(translate('Product has been deleted successfully'))->success();
        return redirect()->route('medicine.index');
    }




}
