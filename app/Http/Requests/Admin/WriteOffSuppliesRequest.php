<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ProductStock; // Make sure to import the model if needed

class WriteOffSuppliesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_sku_code' => [
                'required', // Ensure the field is required
                'exists:product_stocks,sku' // Ensure the product_sku_code exists in the product_stocks table
            ],
            'writeoff_quantities' => [
                'required',
                'integer',
                'min:1', // Minimum quantity to write off should be 1
                function ($attribute, $value, $fail) {
                    // Get the SKU code from the request
                    $skuCode = $this->input('product_sku_code');
                    
                    // Retrieve the product stock from the database based on the SKU code
                    $productStock = ProductStock::where('sku', $skuCode)->first();

                    if (!$productStock) {
                        $fail(__('Product SKU code does not exist.'));
                    } elseif ($value > $productStock->current_stock) {
                        // Check if the write-off quantity exceeds the available stock
                        $fail(__('The quantity cannot exceed the available stock of :stock.', ['stock' => $productStock->current_stock]));
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_sku_code.exists' => __('The selected product SKU code is invalid.'),
            'writeoff_quantities.required' => __('Write-off quantity is required.'),
            'writeoff_quantities.integer' => __('Write-off quantity must be an integer.'),
            'writeoff_quantities.min' => __('Write-off quantity must be at least 1.'),
        ];
    }
}
