<?php

namespace App\Helpers\Enums;

use BenSampo\Enum\Enum;

class ProductStatus extends Enum
{
    const AVAILABLE = 'available';
    const OUT_OF_STOCK = 'out_of_stock';
}
