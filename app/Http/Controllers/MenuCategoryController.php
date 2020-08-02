<?php

namespace App\Http\Controllers;

use App\MenuCategory;
use App\MenuStatus;
use App\Menu;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
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
        $statuses       = MenuStatus::all('id', 'name');
        $menus          = Menu::all('id', 'name');
        $users          = User::all('id', 'name');
        $menuCategories = MenuCategory::filter($request)->paginate();

        return view('web.backend.sections.menus.categories.index')->with(compact('statuses', 'menus', 'users',
            'menuCategories'));
    }

    /**
     * Display the form to create a new Menu.
     */
    public function create(): View
    {
        $menus        = Menu::all('id', 'name');
        $statuses     = MenuStatus::all('id', 'name');
        $defaultOrder = MenuCategory::count() + 1;

        return view('web.backend.sections.menus.categories.create')->with(compact('menus', 'statuses', 'defaultOrder'));
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
        $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'status_id'   => 'required|integer',
            'menu_id'     => 'required|integer',
            'publish_at'  => 'nullable|string',
        ]);

        MenuCategory::create([
            'name'        => $request->name,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'status_id'   => $request->status_id,
            'menu_id'     => $request->menu_id,
            'notes'       => $request->notes,
            'publish_at'  => $request->publish_at,
            'author_id'   => auth()->user()->id,
        ]);

        flash('The new Category was created successfully.')->success();

        return redirect()->route('categories.index');
    }

    /**
     * Display the form to edit an existing Menu instance.
     *
     * @param  MenuCategory  $category
     *
     * @return RedirectResponse|View
     */
    public function edit(MenuCategory $category)
    {
        $menus    = Menu::all('id', 'name');
        $statuses = MenuStatus::all('id', 'name');

        return view('web.backend.sections.menus.categories.edit')->with(compact('menus', 'statuses', 'category'));
    }

    /**
     * Update an existing Menu instance.
     *
     * @param  Request       $request
     * @param  MenuCategory  $category
     *
     * @return RedirectResponse
     */
    public function update(Request $request, MenuCategory $category): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'nullable|string',
            'status_id'   => 'required|integer',
            'menu_id'     => 'required|integer',
            'publish_at'  => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'status_id'   => $request->status_id,
            'menu_id'     => $request->menu_id,
            'notes'       => $request->notes,
            'publish_at'  => $request->publish_at,
        ]);

        flash('The Category was updated successfully.')->success();

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MenuCategory  $category
     *
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(MenuCategory $category): ?bool
    {
        return $category->delete();
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
        return MenuCategory::onlyTrashed()->find($id)->restore();
    }
}
