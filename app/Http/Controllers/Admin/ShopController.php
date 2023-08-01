<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ShopRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    private $shopRepository;
    private $userRepository;

    public function __construct(ShopRepositoryInterface $shopRepository, UserRepositoryInterface $userRepository)
    {
        $this->shopRepository = $shopRepository;
        $this->userRepository = $userRepository;
    }

    public function create(Request $request)
    {
        $validator = Validator($request->all(), [
            // Your validation rules here
        ]);

        if ($validator->fails()) {
            // Handle validation failure
        } else {
            $shop = $this->shopRepository->create($request->all(), $request->file('path'));

            return redirect()->route('home');
        }
    }

    public function detail()
    {
        $data = [
            'title' => 'Shop Detail',
            'shop' => $this->shopRepository->findFirst()
        ];

        return view('admin.shop.detail', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator($request->all(), [
            // Your validation rules here
        ]);

        if ($validator->fails()) {
            // Handle validation failure
        } else {
            $data = [
                'shop_id' => Auth::user()->shop->id,
                'name_shop' => $request->name_shop,
                'phone' => $request->phone,
                'address' => $request->address,
                'desc' => $request->desc,
                'old_path' => Auth::user()->shop->path,
            ];

            $this->shopRepository->update($data, $request->file('path'));

            return redirect()->route('shopDetail')->with('success', 'Shop updated');
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator($request->all(), [
            // Your validation rules here
        ]);

        if ($validator->fails()) {
            // Handle validation failure
        } else {
            $this->userRepository->updatePassword(Auth::user()->id, $request->password);

            return redirect()->route('home')->with('success', 'Password Changed');
        }
    }
}
