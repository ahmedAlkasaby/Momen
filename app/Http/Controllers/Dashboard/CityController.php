<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\MainController;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\CityRequest;

class CityController extends MainController
{


    public function __construct()
    {
        parent::__construct();
        $this->setClass('cities');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::paginate($this->perPage);
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        City::create($request->all());
        return redirect()->route('dashboard.cities.index')->with('success', __('site.city_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $city = City::find($id);
        return view('admin.cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $city = City::find($id);
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, string $id)
    {
        $city = City::find($id);
        $city->update($request->all());
        return redirect()->route('dashboard.cities.index')->with('success', __('site.city_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);

        if ($city->orders()->count() > 0) {
            return redirect()->route('dashboard.cities.index')->with('error', __('site.city_has_orders'));
        }
        if ($city->Regions()->count() > 0) {
            return redirect()->route('dashboard.cities.index')->with('error', __('site.city_has_regions'));
        }
        $city->delete();
        return redirect()->route('dashboard.cities.index')->with('success', __('site.city_deleted_successfully'));
    }

    
}
