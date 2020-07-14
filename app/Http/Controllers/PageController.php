<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
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
        $page = Page::filter($request)->paginate();

        return view('page.index')->with('page', $page);
    }

    /**
     * Display the form to create a new Page.
     */
    public function create(): View
    {
         return view('page.create');
    }

    /**
     * Store a new Page.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
        ]);

        Page::create([$request->all()]);

        flash('The new Page was created successfully.')->success();

        return redirect()->route('page.index');
    }

    /**
     * Display the form to edit an existing Page instance.
     *
     * @param Page $page
     * @return RedirectResponse|View
     */
    public function edit(Page $page)
    {
        return view('users.edit')->with('myModelLower', $page);
    }

    /**
     * Update an existing Page instance.
     *
     * @param  Request  $request
     * @param  Page  $page
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate(['name' => 'required']);

        $page->update($request->all());

        flash('The Page was updated successfully.')->success();

        return redirect()->route('Page.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Page  $page
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Page $page): ?bool
    {
        return $page->delete();
    }
}
