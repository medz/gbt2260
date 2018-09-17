<?php

declare(strict_types=1);

namespace Medz\GBT2260;

interface RegionInterface
{
    /**
   * Get region code.
   *
   * @return {number}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function code(): int;

  /**
   * Get region province.
   *
   * @return {string}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function province(): string;

  /**
   * Get city for region.
   *
   * @return {?string}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function city(): string;

  /**
   * Get count of the region.
   *
   * @return {string}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function county(): string;

  /**
   * Get the region tree.
   *
   * @return {string[]}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function tree(): array;

  /**
   * Get The Region Tree String.
   * 
   * @param {string} glue Join Array Elements With A Glue String
   * @return {string}
   * @author Seven Du <shiweidu@outlook.com>
   */
  public function treeString(?string $glue = null): string;
}
