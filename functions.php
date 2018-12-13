function generateGT25(){
 
    //this  block is same with WooCommerce Create Custom Coupon
    $coupon_code = 'gt25'; // Code
    $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
    
    //cart_total will be used to get sum of regular prices
    //cart_sale will be used to get sum of sale prices
    $cart_total = 0;
    $cart_sale = 0;
    
    foreach ( WC()->cart->get_cart() as $cart_item ) {
                $product = $cart_item['data'];
                $cart_total += $product->get_regular_price() * $cart_item['quantity'];
                if($product->is_on_sale())
    				$cart_sale += $product->get_sale_price() * $cart_item['quantity'];
    				else
    				$cart_sale += $product->get_regular_price() * $cart_item['quantity'];
    }
    
    //assume that you want 25% discount from the regular prices of sale products
    //calculating the discount amount
    $discountA = $cart_total * 25 / 100;
    $discountB = $cart_total - $cart_sale;
    $amount = $discountA - $discountB;
    
    //generating coupon with given coupon code, amount and discount type
    $coupon = array(
    	'post_title' => $coupon_code,
    	'post_content' => '',
    	'post_status' => 'publish',
    	'post_author' => 1,
    	'post_type'		=> 'shop_coupon'
    );
    					
    $new_coupon_id = wp_insert_post( $coupon );
    					
    // Add meta
    update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
    update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
    update_post_meta( $new_coupon_id, 'individual_use', 'no' );
    update_post_meta( $new_coupon_id, 'product_ids', '' );
    update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
    update_post_meta( $new_coupon_id, 'usage_limit', '' );
    update_post_meta( $new_coupon_id, 'expiry_date', '' );
    update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
    update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

}
