<?php

namespace JWorkman\Gutenberg_Block_Manager;

class Gutenberg extends Factory
{
  private $_model;
  public function __construct(array $options = []) {
    $this->_model = $options['model'];
  }

  public function initHooks()
  {
    if (!function_exists('\acf_register_block_type')) {
      throw new \Exception("ACF Pro is required.");
    }
    foreach ($this->_model->getAllCustomComponents() as $ccomponent) {
      $meta = \get_post_meta($ccomponent->ID);
      $meta_keywords = (!isset($meta['keywords'])) ? "" : $meta['keywords'];
      $meta_icon = (!isset($meta['icon'])) ? "" : $meta['icon'];
      $keywords = array_map('trim', explode(',', $meta_keywords));
			\acf_register_block_type([
				'name' => $ccomponent->post_name,
				'title' => $ccomponent->post_title,
				'description' => $ccomponent->post_content,
				'render_callback' => [$this, 'renderComponent'],
				'category' => 'custom',
				'icon' => (($meta_icon) ? $meta_icon : 'align-wide'),
				'keywords' => $keywords
			]);
		}
    return $this;
  }

  public function renderComponent($block)
  {
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
  	$slug = str_replace('acf/', '', $block['name']);

  	// include a template part from within the "template-parts/block" folder
  	$path = __DIR__ . '/Block.php';
  	if( file_exists( $path ) ) {
  		include $path;
  	}
  }
}
