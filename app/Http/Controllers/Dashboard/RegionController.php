<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\RegionRequest;
use App\Http\Controllers\Dashboard\MainController;

class RegionController extends MainController
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        parent::__construct();
        $this->setClass('regions');
    }
    public function index()
    {
        $regions = Region::with('city')->paginate($this->perPage);
        return view('admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.regions.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionRequest $request)
    {
        Region::create($request->all());
        return redirect()->route('dashboard.regions.index')->with('success', __('site.region_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::find($id);
        $cities = City::all();

        return view('admin.regions.show', compact('region', "cities"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::find($id);
        $cities = City::all();

        return view('admin.regions.edit', compact('region', "cities"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $region = Region::find($id);
        $region->update($request->all());
        return redirect()->route('dashboard.regions.index')->with('success', __('site.region_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Region::find($id)->orders()->count() > 0) {
            return redirect()->route('dashboard.regions.index')->with('error', __('site.region_has_orders'));
        }
        $region = Region::find($id);
        $region->delete();
        return redirect()->route('dashboard.regions.index')->with('success', __('site.region_deleted_successfully'));
    }

    
}
