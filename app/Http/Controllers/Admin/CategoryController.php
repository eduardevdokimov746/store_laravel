<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategoryRequest $request)
    {
        $data = $request->only(['parent_id', 'title', 'slug', 'keywords', 'description']);

        if (is_null($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        if (Category::create($data) instanceof Category) {
            \Category::flush();
            return redirect()->route('admin.categories.index')->with(['success' => 'Категория успешно добавлена!']);
        }

        return redirect()->route('admin.categories.index')->withErrors('Не удалось добавить категорию');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!\Category::has($id)) {
            return abort(404);
        }

        $category = Category::find($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->only(['parent_id', 'title', 'slug', 'keywords', 'description']);

        if (is_null($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        if (Category::find($id)->update($data)) {
            \Category::flush();
            return back()->with(['success' => 'Категория успешно обновлена!']);
        }

        return back()->withErrors('Не удалось обновить категорию');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Category::destroy($id)) {
            \Category::flush();
            return redirect()->route('admin.categories.index')->with(['success' => 'Категория успешно удалена!']);
        }

        return redirect()->route('admin.categories.index')->withErrors('Не удалось удалить категорию');
    }
}
