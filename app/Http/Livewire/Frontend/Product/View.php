<?php

namespace App\Http\Livewire\Frontend\Product;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class View extends Component
{
    public $category, $product, $productColorSelectedQuantity, $quantityCount=1;

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
