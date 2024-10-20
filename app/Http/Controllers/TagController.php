<?php

namespace App\Http\Controllers;

use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        $tags = $this->tagRepository->all(10);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $this->tagRepository->create($request->all());

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function show($id)
    {
        $tag = $this->tagRepository->find($id);
        return view('tags.show', compact('tag'));
    }

    public function edit($id)
    {
        $tag = $this->tagRepository->find($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        $this->tagRepository->update($id, $request->all());

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy($id)
    {
        $this->tagRepository->delete($id);

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}