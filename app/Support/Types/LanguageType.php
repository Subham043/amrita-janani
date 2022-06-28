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

class LanguageType extends AbstractFor
{
    protected static $forstatus = [
        '0' => 'Language_type',
        '1' => 'English',
        '2' => 'Hindi',
        '3' => 'Sanskrit',
    ];
}