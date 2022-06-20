<?php

/**
 * This file is part of FusionInvoice.
 *
 * (c) FusionInvoice, LLC <jessedterry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Support\Types;

abstract class AbstractFor
{
    public static function forstatus()
    {
        return static::$forstatus;
    }

    /**
     * Returns an array of forstatus to populate dropdown list.
     *
     * @return array
     */
    public static function lists()
    {
        $forstatus = static::$forstatus;

        unset($forstatus[0]);

        foreach ($forstatus as $key => $status)
        {
            $forstatus[$key] = $status;
        }

        return $forstatus;
    }

    public static function listsAllFlat()
    {
        $forstatus = [];

        foreach (static::$forstatus as $status)
        {
            $forstatus[$status] = $status;
        }

        return $forstatus;
    }

    /**
     * Returns the status key.
     *
     * @param  string $value
     * @return integer
     */
    public static function getStatusId($value)
    {
        // return array_search($value, static::$forstatus);
        return array_search(strtolower($value), array_map('strtolower', static::$forstatus));
    }
}