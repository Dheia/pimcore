<?php

declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Bundle\EcommerceFrameworkBundle\AvailabilitySystem;

use Pimcore\Bundle\EcommerceFrameworkBundle\Model\CheckoutableInterface;

class Availability implements AvailabilityInterface
{
    /**
     * @var CheckoutableInterface
     */
    private $product;

    private bool $available;

    /**
     * @param CheckoutableInterface $product
     * @param bool $available
     */
    public function __construct(CheckoutableInterface $product, bool $available)
    {
        $this->product = $product;
        $this->available = $available;
    }

    /**
     * @return CheckoutableInterface
     */
    public function getProduct(): CheckoutableInterface
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailable(): bool
    {
        return $this->available;
    }
}
