<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->variant_ids && count($request->variant_ids))
        {
            session()->put('attributes',count($request->variant_ids));
        }

        $rules= [
            'name'                      => 'required|max:190',
            'slug'                      => 'nullable|unique:products,slug|string|max:300',
            'category'                  => 'required',
            'price'                     => 'numeric|required',
//            'current_stock'             => 'numeric|required_without:has_variant',
//            'variant_stock'             => 'required_if:has_variant,==,1',
                'variant_stock.*'           => 'required_if:has_variant,==,1',
            'variant_name'             => 'required_if:has_variant,==,1',
            'variant_sku'             => 'required_if:has_variant,==,1',
            'variant_price'             => 'required_if:has_variant,==,1',

            'variant_sku.*'             => 'required_if:has_variant,1|distinct|unique:product_stocks,sku',
            'unit'                      => 'required',
            'video_url'                 => 'required_with:video_provider',
            'minimum_order_quantity'    => 'numeric|min:1',
            'low_stock_to_notify'       => 'numeric|min:0',
            'shipping_fee'              => 'required_if:shipping_type,flat_rate',
//            'estimated_shipping_days'   => 'numeric',
            'special_discount_period'   => 'required_with:special_discount_type',
            'special_discount'          => 'required_with:special_discount_type',

            'campaign_discount'         => 'required_with:campaign',
            'campaign_discount_type'    => 'required_with:campaign'
        ];

        if (!in_array(1,[$request->is_classified,$request->is_catalog]))
        {
            $rules['sku'] = 'required_without:has_variant|unique:product_stocks,sku';
        }

        if (addon_is_activated('ramdhani') && !in_array(1,[$request->is_classified,$request->is_catalog,$request->is_digital]))
        {
            $rules['shipping_class_id'] = authUser()->user_type == "seller" ? 'nullable' : 'required';
            $rules['shipping_fee']      = 'nullable';
            $rules['shipping_type']     = 'nullable';
        }

        return $rules;
    }
}
