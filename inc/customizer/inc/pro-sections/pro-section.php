<?php

// Pro customizer section.
class Minisite_Pro_Section extends WP_Customize_Section {

	// The type of customize section being rendered.
	public $type = 'minisite';

	// Custom button text to output.
	public $pro_text = '';

	// Custom pro button URL.
	public $pro_url = '';

	// Add custom parameters to pass to the JS via JSON.
	public function json() {
		$json = parent::json();

		$json['pro_text'] = $this->pro_text;
		$json['pro_url']  = esc_url( $this->pro_url );

		return $json;
	}

	// Outputs the Underscore.js template.
	protected function render_template() { ?>

		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<# if ( data.pro_text && data.pro_url ) { #>
				<a href="{{ data.pro_url }}" class="" target="_blank">
					<h3 class="accordion-section-title">
						{{ data.title }} <span class="pro-text">{{ data.pro_text }}</span>
					</h3>
				</a>
			<# } #>
		</li>
	<?php }
}
