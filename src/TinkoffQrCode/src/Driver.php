<?php

/*
 * This file is part of the "cashier-provider/tinkoff-qr" project.
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
 * @see https://github.com/cashier-provider/tinkoff-qr
 */

namespace CashierProvider\Tinkoff\QrCode;

use CashierProvider\Core\Facades\Helpers\Model;
use CashierProvider\Core\Services\Driver as BaseDriver;
use CashierProvider\Tinkoff\QrCode\Exceptions\Manager;
use CashierProvider\Tinkoff\QrCode\Helpers\Statuses;
use CashierProvider\Tinkoff\QrCode\Requests\Cancel;
use CashierProvider\Tinkoff\QrCode\Requests\GetQR;
use CashierProvider\Tinkoff\QrCode\Requests\GetState;
use CashierProvider\Tinkoff\QrCode\Requests\Init;
use CashierProvider\Tinkoff\QrCode\Resources\Details;
use CashierProvider\Tinkoff\QrCode\Responses\QrCode;
use CashierProvider\Tinkoff\QrCode\Responses\Refund;
use CashierProvider\Tinkoff\QrCode\Responses\State;
use Helldar\Contracts\Cashier\Http\Response;

class Driver extends BaseDriver
{
    protected $exceptions = Manager::class;

    protected $statuses = Statuses::class;

    protected $details = Details::class;

    public function start(): Response
    {
        $this->init();

        $request = GetQR::make($this->model);

        return $this->request($request, QrCode::class);
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

    protected function init(): void
    {
        $request = Init::make($this->model);

        $response = $this->request($request, Responses\Init::class);

        $external_id = $response->getExternalId();

        $details = $this->details($response->toArray());

        Model::updateOrCreate($this->payment, compact('external_id', 'details'));

        $this->payment->refresh();
    }
}
