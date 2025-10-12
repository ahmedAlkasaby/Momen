<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use App\Models\User;
use App\Models\Region;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard\AddressRequest;

class AddressController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setClass('addresses');
    }
    public function index()
    {
        $addresses = Address::with("city", "region", "user")->paginate($this->perPage);
        return view('admin.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray();
        $cities = City::all()->mapWithKeys(fn($city) => [$city->id => $city->namelang()])->toArray();
        $regions = Region::all()->mapWithKeys(fn($region) => [$region->id => $region->namelang()])->toArray();
        return view('admin.addresses.create', compact('users', 'cities', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
         Address::create($request->all());
        return redirect()->route('dashboard.addresses.index')->with('success', __('site.address_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray();
        $cities = City::all()->mapWithKeys(fn($city) => [$city->id => $city->namelang()])->toArray();
        $regions = Region::all()->mapWithKeys(fn($region) => [$region->id => $region->namelang()])->toArray();
        return view('admin.addresses.show', compact('users', 'cities', 'regions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $address = Address::findOrFail($id);
        $users = User::all()->mapWithKeys(fn($user) => [$user->id => $user->name])->toArray();
        $cities = City::all()->mapWithKeys(fn($city) => [$city->id => $city->namelang()])->toArray();
        $regions = Region::all()->mapWithKeys(fn($region) => [$region->id => $region->namelang()])->toArray();
        return view('admin.addresses.edit', compact('users', 'cities', 'regions', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, string $id)
    {
        $address = Address::findOrFail($id);
        $address->update($request->all());
        return redirect()->route('dashboard.addresses.index')->with('success', __('site.address_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return redirect()->route('dashboard.addresses.index')->with('success', __('site.address_deleted_successfully'));
    }
}
