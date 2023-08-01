<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Validator;
use Str;
use Auth;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $data = [
            'title' => 'Category',
            'category' => $this->categoryRepository->all(),
        ];

        return view('admin.category.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Create category',
        ];

        return view('admin.category.create', $data);
    }

    public function check(Request $request)
    {
        $nameExists = $this->categoryRepository->findByName($request->name);

        if ($nameExists) {
            return response()->json(['status' => 'success', 'message' => 'not available'], 200);
        } else {
            return response()->json(['status' => 'success', 'message' => 'available'], 201);
        }
    }

    public function save(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'path' => 'required',
            'name' => 'required|unique:categories',
        ]);

        if ($validators->fails()) {
            return redirect()->route('categoryCreate')->withErrors($validators)->withInput();
        } else {
            $path = $request->file('path');
            $extension_path = $path->getClientOriginalExtension();
            $full_name_path = Str::random(20) . "." . $extension_path;
            $path->move(public_path('shop/products/'), $full_name_path);

            $data = [
                'shop_id' => Auth::user()->shop->id,
                'name' => $request->name,
                'path' => $full_name_path,
            ];

            $this->categoryRepository->create($data);

            return redirect()->route('category');
        }
    }

    public function delete($id, $path)
    {
        $paths = public_path() . '/shop/products/' . $path;
        if (file_exists($paths)) {
            unlink($paths);
        }

        $this->categoryRepository->delete($id);

        return redirect()->route('category')->with('success', 'Category deleted');
    }
}
