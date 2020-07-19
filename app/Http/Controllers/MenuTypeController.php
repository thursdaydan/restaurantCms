<?php

namespace App\Http\Controllers;

use App\MenuType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuTypeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $types = MenuType::filter($request)->paginate();
        return view('web.backend.sections.menus.types.index')->with('types', $types);
    }

    /**
     * Display the form to create a new Type.
     */
    public function create(): View
    {
        return view('web.backend.sections.menus.types.create');
    }

    /**
     * Store a new Menu.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string']);

        MenuType::create(['name' => $request->name]);

        flash('The new Menu Type was created successfully.')->success();

        return redirect()->route('types.index');
    }

    /**
     * Display the form to edit an existing Type instance.
     *
     * @param  MenuType  $type
     *
     * @return RedirectResponse|View
     */
    public function edit(MenuType $type)
    {
        return view('web.backend.sections.menus.types.edit')->with('type', $type);
    }

    /**
     * Update an existing Type instance.
     *
     * @param  Request   $request
     * @param  MenuType  $type
     *
     * @return RedirectResponse
     */
    public function update(Request $request, MenuType $type): RedirectResponse
    {
        $request->validate(['name' => 'required|string']);

        $type->update(['name' => $request->name]);

        flash('The Menu Type was updated successfully.')->success();

        return redirect()->route('types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MenuType  $type
     *
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(MenuType $type): ?bool
    {
        return $type->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param $id
     *
     * @return bool|null
     * @throms \Exception
     */
    public function restore($id): ?bool
    {
        return MenuType::onlyTrashed()->find($id)->restore();
    }
}
