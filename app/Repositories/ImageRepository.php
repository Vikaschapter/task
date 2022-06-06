<?php

namespace App\Repositories;
use App\Models\Image;

class ImageRepository
{
    public function __construct()
    {
        //
    }

    // public function getAllOrders();
    // public function getOrderById($orderId);
    // public function deleteOrder($orderId);
    // public function createOrder(array $orderDetails);
    // public function updateOrder($orderId, array $newDetails);
    // public function getFulfilledOrders();

    public function getAllImage(){
        $data = Image::all();
        return $data; 
    }

    public function getImageById($ImageId) 
    {
        return Image::findOrFail($ImageId);
    }

    public function deleteImage($ImageId) 
    {
        Image::destroy($ImageId);
    }

    public function createImage(array $data) 
    {
        return Image::create($data);
    }

    public function updateImage($ImageId, array $newDetails) 
    {
        return Image::whereId($ImageId)->update($newDetails);
    }

    public function getFulfilledImag() 
    {
        return Image::where('is_fulfilled', true);
    }
}
