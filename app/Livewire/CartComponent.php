<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public $selectedItems = []; // Holds selected CartDetail IDs

    public function incrementQty($detailId)
    {
        $itemdetail = CartDetail::findOrFail($detailId);
        $qty = 1;
        $itemdetail->updatedetail($itemdetail, $qty, $itemdetail->harga, $itemdetail->diskon);
        $itemdetail->cart->updatetotal($itemdetail->cart, ($itemdetail->harga - $itemdetail->diskon));
    }

    public function decrementQty($detailId)
    {
        $itemdetail = CartDetail::findOrFail($detailId);
        if ($itemdetail->qty > 1) {
            $qty = 1;
            $itemdetail->updatedetail($itemdetail, '-'.$qty, $itemdetail->harga, $itemdetail->diskon);
            $itemdetail->cart->updatetotal($itemdetail->cart, '-'.($itemdetail->harga - $itemdetail->diskon));
        } else {
            $this->removeItem($detailId);
        }
    }

    public function removeItem($detailId)
    {
        $itemdetail = CartDetail::findOrFail($detailId);
        $cart = $itemdetail->cart;
        
        // Update cart total by subtracting the subtotal of the deleted item
        $cart->updatetotal($cart, '-'.$itemdetail->subtotal);
        $itemdetail->delete();

        // Sync selection array
        if (($key = array_search($detailId, $this->selectedItems)) !== false) {
            unset($this->selectedItems[$key]);
            $this->selectedItems = array_values($this->selectedItems);
        }
    }

    public function emptyCart($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        CartDetail::where('cart_id', $cart->id)->delete();
        $cart->update(['total' => 0]);
        $this->selectedItems = [];
    }

    public function toggleSelectAll()
    {
        $user = Auth::user();
        if (!$user) return;

        $activeCart = Cart::where('user_id', $user->id)->where('status_cart', 'cart')->first();
        if (!$activeCart) return;

        $allIds = $activeCart->detail->pluck('id')->toArray();

        if (count($this->selectedItems) === count($allIds)) {
            $this->selectedItems = [];
        } else {
            $this->selectedItems = $allIds;
        }
    }

    public function isAllSelected()
    {
        $user = Auth::user();
        if (!$user) return false;

        $activeCart = Cart::where('user_id', $user->id)->where('status_cart', 'cart')->first();
        if (!$activeCart || $activeCart->detail->count() === 0) return false;

        $allIds = $activeCart->detail->pluck('id')->toArray();
        return count($this->selectedItems) === count($allIds);
    }

    public function proceedToCheckout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if (empty($this->selectedItems)) {
            session()->flash('warning', 'Silakan pilih setidaknya satu produk untuk di-checkout!');
            return;
        }

        $activeCart = Cart::where('user_id', $user->id)->where('status_cart', 'cart')->first();
        if (!$activeCart) {
            return;
        }

        // Split Cart: Get all details that are NOT selected
        $unselectedDetails = $activeCart->detail()->whereNotIn('id', $this->selectedItems)->get();

        if ($unselectedDetails->isNotEmpty()) {
            // Create a temp cart to hold unchecked items
            $tempCart = Cart::create([
                'user_id' => $user->id,
                'no_invoice' => $activeCart->no_invoice . '-TEMP',
                'status_cart' => 'temp',
                'status_pembayaran' => 'belum',
                'subtotal' => 0,
                'total' => 0
            ]);

            foreach ($unselectedDetails as $detail) {
                $detail->update(['cart_id' => $tempCart->id]);
            }

            // Calculate totals for temp cart
            $tempCartTotal = $tempCart->detail()->sum('subtotal');
            $tempCart->update([
                'subtotal' => $tempCartTotal,
                'total' => $tempCartTotal
            ]);
        }

        // Recalculate active cart totals for selected items to be checked out
        $activeCartTotal = $activeCart->detail()->sum('subtotal');
        $activeCart->update([
            'subtotal' => $activeCartTotal,
            'total' => $activeCartTotal
        ]);

        return redirect()->to('/checkout');
    }

    public function render()
    {
        $user = Auth::user();
        $itemcart = null;
        $selectedTotal = 0;
        
        if ($user) {
            // Restore/Merge any existing temp cart back to the active cart if user returned to cart page
            $tempCart = Cart::where('user_id', $user->id)->where('status_cart', 'temp')->first();
            $activeCart = Cart::where('user_id', $user->id)->where('status_cart', 'cart')->first();
            
            if ($tempCart) {
                if (!$activeCart) {
                    $tempCart->update(['status_cart' => 'cart']);
                    $activeCart = $tempCart;
                } else {
                    foreach ($tempCart->detail as $detail) {
                        $existingDetail = CartDetail::where('cart_id', $activeCart->id)
                            ->where('produk_id', $detail->produk_id)
                            ->first();
                            
                        if ($existingDetail) {
                            $existingDetail->qty += $detail->qty;
                            $existingDetail->subtotal += $detail->subtotal;
                            $existingDetail->save();
                            $detail->delete();
                        } else {
                            $detail->update(['cart_id' => $activeCart->id]);
                        }
                    }
                    
                    // Update active cart totals
                    $activeCartTotal = $activeCart->detail()->sum('subtotal');
                    $activeCart->update([
                        'subtotal' => $activeCartTotal,
                        'total' => $activeCartTotal
                    ]);
                    
                    $tempCart->delete();
                }
            }
            
            $itemcart = Cart::with('detail.produk')->where('user_id', $user->id)->where('status_cart', 'cart')->first();
            
            if ($itemcart) {
                // Ensure selected items exist in the active cart
                $validIds = $itemcart->detail->pluck('id')->toArray();
                $this->selectedItems = array_intersect($this->selectedItems, $validIds);
                
                // Calculate selected total
                $selectedTotal = $itemcart->detail->whereIn('id', $this->selectedItems)->sum('subtotal');
            }
        }

        return view('livewire.cart-component', compact('itemcart', 'selectedTotal'));
    }
}
