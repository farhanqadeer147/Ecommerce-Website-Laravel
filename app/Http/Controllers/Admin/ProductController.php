<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\ProductImageRepositoryInterface;
use Validator;
use Str;
use File;

class ProductController extends Controller
{
    private $productRepository;
    private $productVariantRepository;
    private $productImageRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        ProductImageRepositoryInterface $productImageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->productImageRepository = $productImageRepository;
    }

    public function index()
    {
        $data = [
            'products' => $this->productRepository->all(),
            'title' => 'Products'
        ];

        return view('admin.product.index', $data);
    }

    public function create()
    {
        return view('admin.product.create', ['title' => 'Add Product']);
    }

    public function check(Request $request)
    {
        $name = $this->productRepository->findByTitle($request->title);
        if ($name) {
            return response()->json(['status' => 'success', 'messages' => 'not available', 'code' => 200], 200);
        } else {
            return response()->json(['status' => 'success', 'messages' => 'available', 'code' => 201], 201);
        }
    }

    public function save(Request $request)
    {
        // Validation rules here
        $validator = Validator::make($request->all(), [
            // Validation rules for product data
        ]);

        if ($validator->fails()) {
            return redirect()->route('productCreate')->withErrors($validator)->withInput();
        } else {
            $productData = [
                'category_id' => $request->category,
                'title' => $request->title,
                'price' => $request->price,
                'stock' => $request->stock,
                'desc' => $request->desc,
            ];

            $product = $this->productRepository->create($productData);

            $variants = $request->input('variants');

            if ($variants && is_array($variants)) {
                foreach ($variants as $variant) {
                    $variantData = [
                        'product_id' => $product->id,
                        'color' => $variant['color'],
                        'size' => $variant['size'],
                        'stock' => $variant['stock'],
                    ];
                    $this->productVariantRepository->create($variantData);
                }
            }

            return redirect()->route('productAddImages', ['product' => $request->title]);
        }
    }

    public function addImages($product)
    {
        $productData = $this->productRepository->findByTitle($product);

        $data = [
            'title' => 'Add Images - ' . str_replace('-', ' ', $product),
            'product' => $productData,
        ];

        return view('admin.product.addImages', $data);
    }

    public function delete($id)
    {
        $product = $this->productRepository->find($id);

        $dataImage = [];
        foreach ($product->productImage as $item) {
            array_push($dataImage, public_path() . '/shop/products/' . $item->path);
        }

        File::delete($dataImage);

        $this->productRepository->delete($id);
        return redirect()->route('products')->with('success', 'Data product deleted');
    }
}
