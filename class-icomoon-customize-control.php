<?php

if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

class Icomoon_Customize_Control extends WP_Customize_Control
{
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'icomoon';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json()
	{
		parent::to_json();

		$this->json['icons'] = $this->get_icons();
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue()
	{
		wp_enqueue_style( 'iwcc-icons', IWCC_URL . '/icomoon-files/style.css', null );
		wp_enqueue_style( 'iwcc-style', IWCC_URL . '/style.css', null );
		wp_enqueue_script( 'iwcc-script', IWCC_URL . '/main.js', array( 'jquery', 'customize-base' ), false, true );
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template()
	{
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="icons-wrapper">
			<# if ( 'undefined' !== typeof data.choices && 1 < _.size( data.choices ) ) { #>
				<# for ( key in data.choices ) { #>
					<input {{{ data.inputAttrs }}} class="icomoon-select" type="radio" value="{{ key }}" name="_customize-icomoon-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ key }}">
							<span class="{{ data.choices[ key ] }}"></span>
						</label>
					</input>
				<# } #>
			<# } else { #>
				<# for ( key in data.icons ) { #>
					<input {{{ data.inputAttrs }}} class="icomoon-select" type="radio" value="{{ data.icons[ key ] }}" name="_customize-icomoon-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons[ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons[ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons[ key ] }}">
							<span class="icomoon {{ data.icons[ key ] }}"></span>
						</label>
					</input>
				<# } #>
			<# } #>
		</div>
		<?php
	}

	public function get_icons()
	{
		$json = file_get_contents( plugins_url( 'icomoon-files/selection.json', __FILE__ ) );

		if ( ! $json ) {
			return false;
		}

		$items  = json_decode( $json, true );
		$prefix = $items['preferences']['fontPref']['prefix'];

		foreach ( $items['icons'] as $item ) {
			$icons[] = $prefix . $item['properties']['name'];
		}

		return $icons;
	}
}
