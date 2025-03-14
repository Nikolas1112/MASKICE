<?php

namespace App\Repositories\Admin\Addon;

use App\Models\SellerPackage;
use App\Models\SellerPackageLanguage;
use App\Traits\ImageTrait;
use App\Traits\PaymentTrait;

class PackageRepository
{
    use ImageTrait, PaymentTrait;

    public function all()
    {
        return SellerPackage::latest();
    }

    public function paginate($limit,$status=null)
    {
        return $this->all()->when($status == 1, function ($query){
            $query->where('status',1);
        })->paginate($limit);
    }

    public function find($id)
    {
        return SellerPackage::find($id);
    }

    public function store($data)
    {
        if (arrayCheck('image',$data)):
            $data['image_id']     = $data['image'];
            $data['image']        = $this->getImageWithRecommendedSize($data['image'], '150','150', true);
        else:
            $data['image']        = [];
        endif;

        if (arrayCheck('is_free',$data) && $data['is_free'] == 1)
        {
            $data['is_free']    = 1;
            $data['price']      = 0;
        }

        $package = SellerPackage::create($data);

        $this->langCreate($data,$package);

        return $package;
    }

    public function update($data,$id)
    {
        $package = SellerPackage::find($id);

        if (arrayCheck('image',$data)):
            $data['image_id']     = $data['image'];
            $data['image']        = $this->getImageWithRecommendedSize($data['image'], '150','150', true);
        endif;

        if (arrayCheck('is_free',$data) && $data['is_free'] == 1)
        {
            $data['is_free']    = 1;
            $data['price']      = 0;
        }else
        {
            $data['is_free']    = 0;
        }

        $package->update($data);

        if (arrayCheck('lang',$data))
        {
            $package_lang = SellerPackageLanguage::where('seller_package_id',$id)->where('lang',$data['lang'])->first();

            if ($package_lang)
            {
                $package_lang->update([
                    'title' => $data['title'],
                    'lang'  => arrayCheck('lang',$data) ? $data['lang'] : 'en',
                ]);
            }
            else{
                $this->langCreate($data,$package);
            }
        }
        else{
            $this->langCreate($data,$package);
        }
        return $package;
    }

    protected function langCreate($data,$package)
    {
        $data['seller_package_id'] = $package->id;
        $data['lang']       = arrayCheck('lang',$data) ? $data['lang'] : 'en';
        return SellerPackageLanguage::create($data);
    }

    public function destroy($id): int
    {
        $package = $this->find($id);
        $package->languagePackages()->delete();
        $package->delete();
        return $package;
    }

    public function statusChange($request): bool
    {
        $seller                 = SellerPackage::find($request['id']);
        $repo                   = new SellerSubscriptionRepository();
        $activeSubscriptions    = $seller->activeSubscriptions;
        foreach ($activeSubscriptions as $activeSubscription) {
            $repo->statusChange([
                'id'     => $activeSubscription->id,
                'status' => $request['status'] == 1 ? 1 : 0
            ]);
        }

        $seller->status  = $request['status'];
        $seller->save();
        return true;
    }

    public function getByLang($id, $lang)
    {
        if ($lang == null) {
            $slideByLang = SellerPackageLanguage::where('lang', 'en')->where('seller_package_id', $id)->first();
        } else {
            $slideByLang = SellerPackageLanguage::where('lang', $lang)->where('seller_package_id', $id)->first();
            if (blank($slideByLang)) {
                $slideByLang = SellerPackageLanguage::where('lang', 'en')->where('seller_package_id', $id)->first();
                $slideByLang['translation_null'] = 'not-found';
            }
        }

        return $slideByLang;
    }
}
