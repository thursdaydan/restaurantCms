<?php

namespace App\Http\Controllers;

use App\Snippet;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SnippetController extends Controller
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
        $snippet = Snippet::filter($request)->paginate();

        return view('snippet.index')->with('snippet', $snippet);
    }

    /**
     * Display the form to create a new Snippet.
     */
    public function create(): View
    {
         return view('snippet.create');
    }

    /**
     * Store a new Snippet.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
        ]);

        Snippet::create([$request->all()]);

        flash('The new Snippet was created successfully.')->success();

        return redirect()->route('snippet.index');
    }

    /**
     * Display the form to edit an existing Snippet instance.
     *
     * @param Snippet $snippet
     * @return RedirectResponse|View
     */
    public function edit(Snippet $snippet)
    {
        return view('users.edit')->with('myModelLower', $snippet);
    }

    /**
     * Update an existing Snippet instance.
     *
     * @param  Request  $request
     * @param  Snippet  $snippet
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate(['name' => 'required']);

        $snippet->update($request->all());

        flash('The Snippet was updated successfully.')->success();

        return redirect()->route('Snippet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Snippet  $snippet
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Snippet $snippet): ?bool
    {
        return $snippet->delete();
    }
}
