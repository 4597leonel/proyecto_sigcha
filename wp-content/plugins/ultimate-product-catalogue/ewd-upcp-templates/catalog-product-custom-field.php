<div class='ewd-upcp-catalog-product-custom-field'>

	<span><?php echo esc_html( $this->custom_field->name ); ?>:</span>
	
	<?php echo esc_html( is_array( $this->product->custom_fields[ $this->custom_field->id ] ) ? implode( ',', $this->product->custom_fields[ $this->custom_field->id ] ) : $this->product->custom_fields[ $this->custom_field->id ] ); ?>

</div>