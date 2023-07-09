<?php

namespace CashierProvider\BankName\Technology;

use CashierProvider\BankName\Technology\Exceptions\Manager;
use CashierProvider\BankName\Technology\Helpers\Statuses;
use CashierProvider\BankName\Technology\Requests\Cancel;
use CashierProvider\BankName\Technology\Requests\GetState;
use CashierProvider\BankName\Technology\Requests\Init;
use CashierProvider\BankName\Technology\Resources\Details;
use CashierProvider\BankName\Technology\Responses\Created;
use CashierProvider\BankName\Technology\Responses\Refund;
use CashierProvider\BankName\Technology\Responses\State;
use CashierProvider\Core\Services\Driver as BaseDriver;
use Helldar\Contracts\Cashier\Http\Response;

class Driver extends BaseDriver
{
    protected $exceptions = Manager::class;

    protected $statuses = Statuses::class;

    protected $details = Details::class;

    public function start(): Response
    {
        $request = Init::make($this->model);

        return $this->request($request, Created::class);
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
