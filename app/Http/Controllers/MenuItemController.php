<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuCategory;
use App\MenuItem;
use App\MenuStatus;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
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
        $users          = User::all('id', 'name');
        $menus          = Menu::all('id', 'name');
        $menuCategories = MenuCategory::all('id', 'name');
        $statuses       = MenuStatus::all('id', 'name');
        $items          = MenuItem::filter($request)->paginate();

        return view('web.backend.sections.menus.items.index')->with(compact('statuses', 'menus', 'users',
            'menuCategories', 'items'));
    }

    /**
     * Display the form to create a new Menu.
     */
    public function create(): View
    {
        $menus        = Menu::all('id', 'name');
        $categories   = MenuCategory::all('id', 'name');
        $items        = MenuItem::all('id', 'name');
        $statuses     = MenuStatus::all('id', 'name');
        $defaultOrder = MenuItem::count() + 1;

        return view('web.backend.sections.menus.items.create')->with(compact('menus', 'categories', 'items', 'statuses',
            'defaultOrder'));
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
            'description' => 'string',
            'status_id'   => 'required|integer',
            'menu_id'     => 'required|integer',
            'category_id' => 'nullable|integer',
            'parent_id'   => 'nullable|integer',
            'cost'        => 'nullable',
            'price'       => 'required',
            'gluten_free' => 'nullable|boolean',
            'vegetarian'  => 'nullable|boolean',
            'vegan'       => 'nullable|boolean',
            'publish_at'  => 'nullable|string',
        ]);

        MenuItem::create([
            'name'        => $request->name,
            'description' => $request->description,
            'status_id'   => $request->status_id,
            'menu_id'     => $request->menu_id,
            'category_id' => $request->category_id,
            'parent_id'   => $request->parent_id,
            'cost'        => $request->cost,
            'price'       => $request->price,
            'gluten_free' => $request->has('gluten_free'),
            'vegetarian'  => $request->has('vegetarian'),
            'vegan'       => $request->has('vegan'),
            'publish_at'  => $request->publish_at,
            'author_id'   => auth()->user()->id,
        ]);

        flash('The new Menu Item was created successfully.')->success();

        return redirect()->route('items.index');
    }

    /**
     * Display the form to edit an existing Menu instance.
     *
     * @param  MenuItem  $item
     *
     * @return RedirectResponse|View
     */
    public function edit(MenuItem $item)
    {
        $menus      = Menu::all('id', 'name');
        $categories = MenuCategory::all('id', 'name');
        $items      = MenuItem::all('id', 'name');
        $statuses   = MenuStatus::all('id', 'name');

        return view('web.backend.sections.menus.items.edit')->with(compact('menus', 'categories', 'items', 'statuses', 'item'));
    }

    /**
     * Update an existing Menu instance.
     *
     * @param  Request   $request
     * @param  MenuItem  $item
     *
     * @return RedirectResponse
     */
    public function update(Request $request, MenuItem $item): RedirectResponse
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'string',
            'status_id'   => 'required|integer',
            'menu_id'     => 'required|integer',
            'category_id' => 'nullable|integer',
            'parent_id'   => 'nullable|integer',
            'cost'        => 'nullable',
            'price'       => 'required',
            'gluten_free' => 'nullable|boolean',
            'vegetarian'  => 'nullable|boolean',
            'vegan'       => 'nullable|boolean',
            'publish_at'  => 'nullable|string',
        ]);

        $item->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status_id'   => $request->status_id,
            'menu_id'     => $request->menu_id,
            'category_id' => $request->category_id,
            'parent_id'   => $request->parent_id,
            'cost'        => $request->cost,
            'price'       => $request->price,
            'gluten_free' => $request->has('gluten_free'),
            'vegetarian'  => $request->has('vegetarian'),
            'vegan'       => $request->has('vegan'),
            'publish_at'  => $request->publish_at,
        ]);

        flash('The Menu Item was updated successfully.')->success();

        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MenuItem  $item
     *
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(MenuItem $item): ?bool
    {
        return $item->delete();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param $id
     * @return bool|null
     * @throms \Exception
     */
    public function restore($id): ?bool
    {
        return MenuItem::onlyTrashed()->find($id)->restore();
    }
}
