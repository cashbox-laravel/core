<?php

declare(strict_types=1);

namespace CashierProvider\Tinkoff\Credit\Requests;

use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Http\Request;
use DragonCode\Support\Facades\Helpers\Str;
use Lmc\HttpConstants\Header;

abstract class BaseRequest extends Request
{
    protected $production_host = 'https://forma.tinkoff.ru';

    protected $headers = [
        Header::ACCEPT       => 'application/json',
        Header::CONTENT_TYPE => 'application/json',
    ];

    public function getRawHeaders(): array
    {
        return $this->headers;
    }

    public function getHttpOptions(): array
    {
        if ($this->hash) {
            return ['auth' => [$this->getShowCaseId(), $this->model->getClientSecret()]];
        }

        return [];
    }

    protected function getShowCaseId(): string
    {
        return Main::isProduction() ? $this->model->getShowCaseId() : Str::start($this->model->getShowCaseId(), 'demo-');
    }

    protected function getPath(): ?string
    {
        return str_replace('{orderNumber}', $this->model->getPaymentId(), $this->getUri());
    }

    protected function getUri(): string
    {
        if (Main::isProduction()) {
            return $this->path;
        }

        return $this->path_dev ?? $this->path;
    }
}
