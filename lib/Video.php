<?php

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

namespace Pimcore;

/**
 * @internal
 */
class Video
{
    /**
     * @param string|null $adapter
     *
     * @return Video\Adapter|null
     *
     * @throws \Exception
     */
    public static function getInstance($adapter = null)
    {
        try {
            if ($adapter) {
                $adapterClass = '\\Pimcore\\Video\\Adapter\\' . $adapter;
                if (Tool::classExists($adapterClass)) {
                    return new $adapterClass();
                } else {
                    throw new \Exception('Video-transcode adapter `' . $adapter . '´ does not exist.');
                }
            } else {
                if ($adapter = self::getDefaultAdapter()) {
                    return $adapter;
                }
            }
        } catch (\Exception $e) {
            Logger::crit('Unable to load video adapter: ' . $e->getMessage());

            throw $e;
        }

        return null;
    }

    /**
     * @return bool
     */
    public static function isAvailable()
    {
        if (self::getDefaultAdapter()) {
            return true;
        }

        return false;
    }

    private static function getDefaultAdapter(): ?Video\Adapter
    {
        $adapters = ['Ffmpeg'];

        foreach ($adapters as $adapter) {
            $adapterClass = '\\Pimcore\\Video\\Adapter\\' . $adapter;
            if (Tool::classExists($adapterClass)) {
                try {
                    $adapter = new $adapterClass();
                    if ($adapter->isAvailable()) {
                        return $adapter;
                    }
                } catch (\Exception $e) {
                    Logger::warning((string) $e);
                }
            }
        }

        return null;
    }
}
