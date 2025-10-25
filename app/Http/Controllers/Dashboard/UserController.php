<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\Role;
use App\Services\ImageHandlerService;

class UserController extends MainController
{
    protected $imageService;
    public function __construct(ImageHandlerService $imageService)
    {
        parent::__construct();
        $this->setClass(request('type'));
        $this->imageService = $imageService;
    }

    public function index()
    {
        $users = User::filter()->paginate($this->perPage);
        return view('admin.users.index', compact('users'));
    }


    public function create()
    {
        $roles = Role::pluck('name', 'id')->toArray();
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $imageUrl = $this->imageService->uploadImage('users', $request);
        $data = $request->except('image');
        $data['image'] = $imageUrl;
        $user = User::create($data);
        $user->addRoles($request->roles);
        return redirect()->route('dashboard.users.index')->with('success', __('site.added_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id')->toArray();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.show', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id')->toArray();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $imgUrl = $this->imageService->editImage($request, $user, 'users');
        $data = $request->except('image');
        $data['image'] = $imgUrl;
        $user->update( $data);
        $user->syncRoles($request->roles);
        return redirect()->route('dashboard.users.index')->with('success', __('site.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
