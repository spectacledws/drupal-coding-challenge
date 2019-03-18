<?php

namespace Drupal\Tests\semanticbits\Functional;

use Drupal\block\Entity\Block;

/**
 * Tests semanticbits basic block functionality.
 *
 * @group semanticbits
 */
class SemanticBitsBlockTest extends BlockTestBase {

  /**
   * Test configuring and moving a semanticbits block to specific regions.
   */
  public function testBlock() {
    // Select the 'SemanticBitsBlockl' block to be configured and moved.
    $block = [];
    $block['id'] = 'semantic_bits_block';
    $block['settings[label]'] = $this->randomMachineName(8);
    $block['settings[label_display]'] = TRUE;
    $block['theme'] = $this
      ->config('system.theme')
      ->get('default');
    $block['region'] = 'content';

    // Set block title.
    $this->drupalPostForm('admin/structure/block/add/' . $block['id'] . '/' . $block['theme'], [
      'settings[label]' => $block['settings[label]'],
      'settings[label_display]' => $block['settings[label_display]'],
      'id' => $block['id'],
      'region' => $block['region'],
    ], t('Save block'));
    $this->assertText(t('The block configuration has been saved.'), 'Block title set.');

    // Check whether the block can be moved to all available regions.
    foreach ($this->regions as $region) {
      $this->moveBlockToRegion($block, $region);
    }
  }
}
