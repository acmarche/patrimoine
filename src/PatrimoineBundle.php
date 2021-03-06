<?php
/**
 * This file is part of sf5 application
 * @author jfsenechal <jfsenechal@gmail.com>
 * @date 16/11/19
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace AcMarche\Patrimoine;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PatrimoineBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

}
