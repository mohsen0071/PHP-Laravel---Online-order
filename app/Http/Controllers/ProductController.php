<?php

namespace App\Http\Controllers;

use App\Category;
use App\Discount;
use App\Product;
use App\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;


class ProductController extends Controller
{
    public function index(Request $request, $categoryId)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $products = Product::where('category_id', $categoryId)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        return response($products);
    }

    public function category(Request $request, $categoryId)
    {
        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $category = Category::where('parent_id', $categoryId)->where('status','1')
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        return response($category);
    }

    public function product(Request $request)
    {
        $productId = $request->input('productId');
        $clientId = $request->input('clientId');

        if (!$request->ajax()) {
            throw new MethodNotAllowedException(['ajax']);
        }

        $products = Product::with(['pservices','category'])->where('id', $productId)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        $userType = User::where('id',$clientId)->first();

        foreach ($products as $key => $product)
        {
            $discount = $this->getDiscount($productId,$clientId);
            if($discount)
            {
                $products[$key]['discount'] =  $discount->amount;
            }
            else
            {
                $products[$key]['discount'] = 0;
            }

        }


        if($userType->user_type == 2)
        {
            foreach ($products as $key => $product)
            {
                if($product['partner_price'] != Null)
                {
                    $products[$key]['price'] = $product['partner_price'];
                }
                if($product['partner_urgent_price'] != Null)
                {
                    $products[$key]['urgent_price'] = $product['partner_urgent_price'];
                }
            }
        }

        return response($products);
    }

    public function getDiscount($productId, $clientId)
    {
        $v = new Verta();

        $discount = Discount::where('status',1)->latest()->first();

        if($discount){
            if($discount->expireDate)
            {
                if($discount->expireDate >= $v->format('Y/m/d'))
                {
                    if(count($discount->client_group) > 0)
                    {
                        if(in_array($clientId, $discount->client_group))
                        {
                            return $discount;
                        }
                        else
                        {
                            return 0;
                        }
                    }

                    if(count($discount->product_group) > 0)
                    {
                        if(in_array($productId, $discount->product_group))
                        {
                            return $discount;
                        }
                        else
                        {
                            return 0;
                        }
                    }

                    return $discount;

                }
                else
                {
                    return 0;
                }
            }
            else
            {
                if(count($discount->client_group) > 0)
                {
                    if(in_array($clientId, $discount->client_group))
                    {
                        return $discount;
                    }
                    else
                    {
                        return 0;
                    }
                }

                if(count($discount->product_group) > 0)
                {
                    if(in_array($productId, $discount->product_group))
                    {
                        return $discount;
                    }
                    else
                    {
                        return 0;
                    }
                }

                return $discount;
            }
        }


    }

}
