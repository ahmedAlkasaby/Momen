<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\UnitRequest;

class UnitController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setClass('units');
    }
    public function index()
    {
        $units = Unit::filter(request(), "dashboard")->paginate($this->perPage);
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $data=$request->all();
        Unit::create($data);

        return redirect()->route('dashboard.units.index')->with('success', __('site.unit_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);
        return view('admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());

        return redirect()->route('dashboard.units.index')->with('success', __('site.unit_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if($unit->products()->count() > 0){
            return redirect()->route('dashboard.units.index')->with('error', __('site.unit_cant_be_deleted'));
        }
        $unit->delete();
        return redirect()->route('dashboard.units.index')->with('success', __('site.unit_deleted_successfully'));
    }

    
    
    
}
