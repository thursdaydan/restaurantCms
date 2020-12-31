<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Menu;
use App\MenuLayout;
use App\MenuStatus;
use App\MenuType;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
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
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $statuses = MenuStatus::all('id', 'name');
        $types = MenuType::all('id', 'name');
        $users = User::all('id', 'name');
        $menus = Menu::filter($request)->paginate();

        return view('web.backend.sections.menus.index')
            ->with(compact('menus', 'statuses', 'types', 'users'));
    }

    /**
     * Display the form to create a new Menu.
     */
    public function create(): View
    {
        $statuses = MenuStatus::all('id', 'name');
        $types = MenuType::all('id', 'name');
        $currencies = Currency::all('id', 'name', 'symbol');
        $layouts = MenuLayout::all('id', 'name');
        $defaultOrder = Menu::count() + 1;

         return view('web.backend.sections.menus.create')
             ->with(compact('statuses', 'types', 'currencies', 'layouts', 'defaultOrder'));
    }

    /**
     * Store a new Menu.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'           => 'required|string',
            'description'    => 'string',
            'status_id'      => 'required|integer',
            'type_id'        => 'required|integer',
            'menu_layout_id' => 'require|integer',
            'currency_id'    => 'required|integer',
            'header_text'    => 'nullable|string',
            'footer_text'    => 'nullable|string',
            'notes'          => 'nullable|string',
            'publish_at'     => 'nullable|string'
        ]);

        Menu::create([
            'name'           => $request->name,
            'description'    => $request->description,
            'status_id'      => $request->status_id,
            'type_id'        => $request->type_id,
            'menu_layout_id' => $request->menu_layout_id,
            'currency_id'    => $request->currency_id,
            'header_text'    => $request->header_text,
            'footer_text'    => $request->footer_text,
            'notes'          => $request->notes,
            'publish_at'     => $request->publish_at,
            'author_id'      => auth()->user()->id,
        ]);

        flash('The new Menu was created successfully.')->success();

        return redirect()->route('menus.index');
    }

    /**
     * Display the profile of an existing Menu instance.
     *
     * @param Menu $menu
     * @return RedirectResponse|View
     */
    public function show(Menu $menu)
    {
        $menu->load('categories.items');

        return view('web.backend.sections.menus.show')->with('menu', $menu);
    }

    /**
     * Display the form to edit an existing Menu instance.
     *
     * @param Menu $menu
     * @return RedirectResponse|View
     */
    public function edit(Menu $menu)
    {
        $statuses = MenuStatus::all('id', 'name');
        $types = MenuType::all('id', 'name');
        $currencies = Currency::all('id', 'name', 'symbol');
        $layouts = MenuLayout::all('id', 'name');

        return view('web.backend.sections.menus.edit')
            ->with(compact('menu', 'statuses', 'types', 'currencies', 'layouts'));
    }

    /**
     * Update an existing Menu instance.
     *
     * @param  Request  $request
     * @param  Menu  $menu
     * @return RedirectResponse
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $request->validate([
            'name'           => 'required|string',
            'description'    => 'string',
            'status_id'      => 'required|integer',
            'type_id'        => 'required|integer',
            'menu_layout_id' => 'required|integer',
            'currency_id'    => 'required|integer',
            'order'          => 'required|integer',
            'header_text'    => 'nullable|string',
            'footer_text'    => 'nullable|string',
            'notes'          => 'nullable|string',
            'publish_at'     => 'nullable|string',
        ]);

        $menu->update([
            'name'           => $request->name,
            'description'    => $request->description,
            'status_id'      => $request->status_id,
            'type_id'        => $request->type_id,
            'menu_layout_id' => $request->menu_layout_id,
            'currency_id'    => $request->currency_id,
            'header_text'    => $request->header_text,
            'footer_text'    => $request->footer_text,
            'notes'          => $request->notes,
            'publish_at'     => $request->publish_at,
        ]);

        flash('The Menu was updated successfully.')->success();

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Menu  $menu
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Menu $menu): ?bool
    {
        return $menu->delete();
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
        return Menu::onlyTrashed()->find($id)->restore();
    }
}
