<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $category, $product, $productColorSelectedQuantity, $quantityCount=1, $productColorId;

    public function addToWishList($productId){
        if(Auth::check()){
            if(Wishlist::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists()){
                session()->flash('message','Already Added to Wishlist');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Already Added to Wishlist',
                    'type' => 'warning',
                    'status' => 409
                ]);
                return false;
            }else{
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                $this->emit('wishlistAddedUpdated');
                session()->flash('message','Wishlist Added Successfully');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Wishlist Added Successfully',
                    'type' => 'success',
                    'status' => 200
                ]);
            }
            
        }else{
            session()->flash('message','Please Login to continue');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Login to continue',
                'type' => 'info',
                'status' => 401
            ]);

            return false;
        }
    }

    public function colorSelected($productColorId){
        // dd($productColorId);
        $this->productColoerId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->productColorSelectedQuantity = $productColor->quantity;

        if($this->productColorSelectedQuantity == 0){
            $this->productColorSelectedQuantity = 'outOfStock';
        }
    }

    public function incrementQuantity(){
        if($this->quantityCount < 10){
            $this->quantityCount++;
        }  
    }
    public function decrementQuantity(){
        if($this->quantityCount > 1){
            $this->quantityCount--;
        } 
    }

    public function addToCart(int $productId){
        if(Auth::check())
        {
            // dd($productId);
            if($this->product->where('id', $productId)->where('status','0')->exists())
            {
               
                //Check for product color Quantity and add to cart
                if($this->product->productColors()->count() > 1)
                {
                    if($this->productColorSelectedQuantity != null)
                    {
                        if(Cart::where('user_id',auth()->user()->id)
                                ->where('product_id', $productId)
                                ->where('product_color_id', $this->productColoerId)
                                ->exists())
                        {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Product Already Added',
                                'type' => 'success',
                                'status' => 200
                            ]);
                        } 
                        else
                        {
                            $productColor = $this->product->productColors()->where('id', $this->productColoerId)->first();
                            if($productColor->quantity > 0)
                            {
                                if($productColor->quantity > $this->quantityCount)
                                {
                                    //insert product to cart
                                    Cart::create([
                                        'user_id' => Auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColoerId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Product Added to Cart',
                                        'type' => 'success',
                                        'status' => 200
                                    ]);
                                }
                                else
                                {
                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Only'.$productColor->quantity.'Quantity avilable',
                                        'type' => 'worning',
                                        'status' => 404
                                    ]);
                                }
                            }
                            else
                            {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Out of Stock',
                                    'type' => 'worning',
                                    'status' => 404
                                ]);
                            }
                        }                       
                    }
                    else
                    {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Select Your Product Color',
                            'type' => 'info',
                            'status' => 404
                        ]);
                    }
                }
                else
                {
                    if(Cart::where('user_id',auth()->user()->id)->where('product_id', $productId)->exists())
                    {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Product Already Added',
                            'type' => 'worning',
                            'status' => 200
                        ]);
                    }
                    else
                    {
                        if($this->product->quantity > 0)
                        {
                            if($this->product->quantity > $this->quantityCount)
                            {
                                //insert product to cart
                                Cart::create([
                                    'user_id' => Auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Product Added to Cart',
                                    'type' => 'success',
                                    'status' => 200
                                ]);
                            }
                            else
                            {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Only'.$this->product->quantity.'Quantity avilable',
                                    'type' => 'worning',
                                    'status' => 404
                                ]);
                            }
                        }
                        else
                        {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Out of Stock',
                                'type' => 'worning',
                                'status' => 404
                            ]);
                        }
                    }
                }  
            }
            else
            {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Product Dose not exists',
                    'type' => 'worning',
                    'status' => 404
                ]);
            }
        }
        else
        {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Login to Add to Cart',
                'type' => 'info',
                'status' => 401
            ]);
        }
    }

    public function mount($category, $product){
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.view',[
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
