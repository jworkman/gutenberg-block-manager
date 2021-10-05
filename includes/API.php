<?php
namespace JWorkman\Gutenberg_Block_Manager;

class API extends Factory
{
  public function getObjectComponentJSON($object)
  {
    // Only if we have a "content" property on this object will we parse it
    if (isset($object["content"]) && isset($object["content"]["raw"]) && $object["content"]["rendered"]) {

      // We are going to grab all of the preg_matches and place them into groups
      $component_payloads = [];
      preg_match_all(
        '/\<\!------\ GBM\ Component\ ---------\%\>(?<payload>.*)\<\/------\ GBM\ Component\ ---------\?\>/',
        $object["content"]["rendered"],
        $component_payloads,
        PREG_PATTERN_ORDER
      );

      $blocks = parse_blocks($object["content"]["raw"]);
      for ($i=0; $i < count($blocks); $i++) {
        // If we have an ACF block we need to pipe ACF fields into
        if (preg_match("/^acf\/.*/", $blocks[$i]["blockName"]) === 1 && isset($component_payloads["payload"]) && isset($component_payloads["payload"][$i])) {
          $blocks[$i]['acf'] = json_decode($component_payloads["payload"][$i]);
        }
      }
      return $blocks;
      // return $blocks;
      // return $object["content"]["rendered"];
    }
  }
  public function initHooks()
  {
    // $blocks = parse_blocks($post->post_content);
    register_rest_field(['post', 'page'], 'components', [
      'get_callback' => [$this, 'getObjectComponentJSON']
    ]);
  }
}
