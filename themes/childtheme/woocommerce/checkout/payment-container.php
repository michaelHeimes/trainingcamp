<?php
/**
 * Template name: payment-container
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wc_payment_method payment_method_<?php echo $gateway->id; ?> tab-content" id="<?php echo $gateway->id; ?>">
<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo $gateway->id; ?> " <?php if ( ! $gateway->chosen ) : ?>"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</div>


