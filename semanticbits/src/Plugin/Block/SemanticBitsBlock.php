<?php

namespace Drupal\semanticbits\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;
/**
 * Provides a 'SemanticBitsBlock' block.
 *
 * @Block(
 *  id = "semantic_bits_block",
 *  admin_label = @Translation("Semantic bits block"),
 * )
 */
class SemanticBitsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Get all content that has been modified today.
    $today = date('Y-m-d');
    $startofday = strtotime($today . '00:00:00');
    $nids = \Drupal::entityQuery('node')->condition('changed', $startofday, '>=')->execute();
    $nodes =  Node::loadMultiple($nids);

    // Now you have all the nodes you can create renderable info.
    $node_array = [];
    foreach ($nodes as $node) {
      $id = $node->id();
      // Get the url for a link.
      $options = ['absolute' => true];
      $url = Url::fromRoute('entity.node.canonical', ['node' => $id], $options);
      $url_string = $url->toString();
      $node_array[$id] = [
        'nodetitle' => $node->get('title')->value,
        'nodeurl' => $url_string,
      ];
    }
    return [
      '#theme' => 'semanticbitsblock',
      '#nodes' => $node_array,
    ];
  }

}
