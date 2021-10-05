<?php

namespace JWorkman\Gutenberg_Block_Manager;

class Model extends Factory
{
  public function getAllCustomComponents()
  {
    $args = [
      'post_type' => GUTENBERG_BLOCK_MANAGER_CPT_SLUG,
      'posts_per_page' => -1
    ];
    $components = get_posts($args);
    return $components;
  }
}
