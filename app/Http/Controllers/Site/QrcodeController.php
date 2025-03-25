<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class QrcodeController extends Controller
{
    public function generateQrcode(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
       
        $sku = $product->barcode ?? null;
        $title = $product->product_name;
        $brand = $product->brand->title ?? 'N/A';
        $stockStatus = $product->current_stock > 0 ? 'In Stock' : 'Out of Stock';
        $webstoreStock = $product->current_stock;

        if (empty($sku)) {
            return response()->json(['error' => 'Product barcode is missing'], 400);
        }
    
        $plainText = "Title: {$title}\n" .
             "Brand: {$brand}\n" .
             "SKU: {$sku}\n" .
             "Stock Status: {$stockStatus}\n" .
             "Webstore Stock: {$webstoreStock}";
        
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $plainText,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );
        $result = $builder->build();
        $qrCodeImageData = $result->getString();
        
        $qrCodeDir = public_path('qrcodes');
        if (!file_exists($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
        }
    
        $filePath = $qrCodeDir . '/' . $sku . '.png';
        $saved = file_put_contents($filePath, $qrCodeImageData);
        if ($saved === false) {
            Log::error("Failed to store QR code image at path: {$filePath}");
            return response()->json(['error' => 'Failed to store QR code image'], 500);
        }
    
        $qrCodeUrl = asset('qrcodes/' . $sku . '.png');
        Log::info("QR code image stored at: {$qrCodeUrl}");
        
        return response()->json([
            'qr_code_url' => $qrCodeUrl,
        ]);
    }
}
