<?php

/*
 * This file is part of the "cashier-provider/tinkoff-online" project.
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
 * @see https://github.com/cashier-provider/tinkoff-online
 */

namespace CashierProvider\Tinkoff\Online;

use CashierProvider\Core\Facades\Helpers\Model;
use CashierProvider\Core\Services\Driver as BaseDriver;
use CashierProvider\Tinkoff\Online\Exceptions\Manager;
use CashierProvider\Tinkoff\Online\Helpers\Statuses;
use CashierProvider\Tinkoff\Online\Requests\Cancel;
use CashierProvider\Tinkoff\Online\Requests\GetState;
use CashierProvider\Tinkoff\Online\Requests\Init;
use CashierProvider\Tinkoff\Online\Resources\Details;
use CashierProvider\Tinkoff\Online\Responses\Refund;
use CashierProvider\Tinkoff\Online\Responses\State;
use DragonCode\Contracts\Cashier\Http\Response;

class Driver extends BaseDriver
{
    protected $exceptions = Manager::class;

    protected $statuses = Statuses::class;

    protected $details = Details::class;

    public function start(): Response
    {
        $request = Init::make($this->model);

        $response = $this->request($request, Responses\Init::class);

        $external_id = $response->getExternalId();

        $details = $this->details($response->toArray());

        Model::updateOrCreate($this->payment, compact('external_id', 'details'));

        $this->payment->refresh();

        return $response;
    }

    public function check(): Response
    {
        $request = GetState::make($this->model);

        return $this->request($request, State::class);
    }

    public function refund(): Response
    {
        $request = Cancel::make($this->model);

        return $this->request($request, Refund::class);
    }
}
