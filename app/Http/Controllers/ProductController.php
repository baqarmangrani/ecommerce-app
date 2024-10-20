<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $paginatedProducts = $this->productRepository->all(10, $request);
        $allProducts = $this->productRepository->all();

        return view('products.index', compact('paginatedProducts', 'allProducts'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->all();
        return view('products.create', compact('categories'));
    }

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->productRepository->find($id);
        $categories = $this->categoryRepository->all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validateProduct($request);

        $this->productRepository->update($id, $request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function store(Request $request)
    {
        $this->validateProduct($request);

        $this->productRepository->create($request->all());
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function restock(Request $request, $id)
    {
        $this->validateRestock($request);

        $this->productRepository->restock($id, $request->quantity);

        return redirect()->route('products.index')->with('success', 'Product restocked successfully.');
    }

    private function validateProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);
    }

    private function validateRestock(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    }
}
