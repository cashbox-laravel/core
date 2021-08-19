<?php

/*
 * This file is part of the "andrey-helldar/cashier" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/andrey-helldar/cashier
 */

declare(strict_types=1);

namespace Helldar\Cashier\Jobs;

use Helldar\Contracts\Cashier\Http\Response;

class Start extends Base
{
    public function handle()
    {
        $data = $this->process();

        $this->store($data);
    }

    protected function process(): Response
    {
        return $this->driver()->start();
    }
}
