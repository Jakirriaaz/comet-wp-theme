<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>

<!-- desire
    
<div class="col-md-3 col-sm-6">
    <div class="shop-product">
        <div class="product-thumb">
        <a href="#">
            <img src="images/shop/1.jpg" alt="">
        </a>
        <div class="product-overlay"><a href="#" class="btn btn-color-out btn-sm">Add To Cart<i class="ti-bag"></i></a>
        </div>
        </div>
        <div class="product-info">
        <h4 class="upper"><a href="#">Premium Notch Blazer</a></h4><span>$79.99</span>
        <div class="save-product"><a href="#"><i class="icon-heart"></i></a>
        </div>
        </div>
    </div>
</div> -->

<!-- default
    
<li class="product type-product post-17 status-publish instock product_cat-tshirts has-post-thumbnail taxable shipping-taxable purchasable product-type-simple">
	<a href="http://localhost/comet/product/polo/" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img width="300" height="300" src="http://localhost/comet/wp-content/uploads/2021/06/lauren-mancke-aOC7TSLb1o8-unsplash-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="--- altChange ---" loading="lazy" srcset="http://localhost/comet/wp-content/uploads/2021/06/lauren-mancke-aOC7TSLb1o8-unsplash-300x300.jpg 300w, http://localhost/comet/wp-content/uploads/2021/06/lauren-mancke-aOC7TSLb1o8-unsplash-100x100.jpg 100w, http://localhost/comet/wp-content/uploads/2021/06/lauren-mancke-aOC7TSLb1o8-unsplash-150x150.jpg 150w, http://localhost/comet/wp-content/uploads/2021/06/lauren-mancke-aOC7TSLb1o8-unsplash-600x600.jpg 600w" sizes="(max-width: 300px) 100vw, 300px"><h2 class="woocommerce-loop-product__title">Polo</h2>
	<span class="price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">৳&nbsp;</span>20.00</bdi></span></span>
</a><a href="?add-to-cart=17" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="17" data-product_sku="woo-polo" aria-label="Add “Polo” to your cart" rel="nofollow">Add to cart</a></li> -->

<div class="col-md-3 col-sm-6" <?php //wc_product_class( '', $product ); ?>>
    <div class="shop-product">
        <div class="product-thumb">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
            <div class="product-overlay">

                <?php global $product;

                echo apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                        esc_attr( isset( $args['class'] ) ? $args['class'] : 'btn btn-color-out btn-sm' ),
                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                        esc_html( $product->add_to_cart_text() )
                    ),
                    $product,
                    $args
                );
              
                ?>

            </div>
        </div>

        <div class="product-info">
            <h4 class="upper"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4><span>
                <?php global $product; echo $product->get_price_html(); ?></span>
            <div class="save-product"><a href="#"><i class="icon-heart"></i></a></div>
        </div>
    </div>
</div>
