<?php

/*
 * This file is part of the "cashier-provider/sber-qr" project.
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
 * @see https://github.com/cashier-provider/sber-qr
 */

namespace Tests\Fixtures\Resources;

use CashierProvider\Sber\QrCode\Resources\Model as BaseModel;
use Illuminate\Support\Carbon;

/** @property \Tests\Fixtures\Models\ReadyPayment $model */
class Model extends BaseModel
{
    public function getMemberId(): string
    {
        return config('cashier.drivers.sber_qr.member_id');
    }

    public function getTerminalId(): string
    {
        return config('cashier.drivers.sber_qr.terminal_id');
    }

    public function getCertificatePath(): ?string
    {
        return config('cashier.drivers.sber_qr.certificate_path');
    }

    public function getCertificatePassword(): ?string
    {
        return config('cashier.drivers.sber_qr.certificate_password');
    }

    protected function paymentId(): string
    {
        return $this->model->uuid;
    }

    protected function sum(): float
    {
        return $this->model->sum;
    }

    protected function currency(): string
    {
        return $this->model->currency;
    }

    protected function createdAt(): Carbon
    {
        return $this->model->created_at;
    }
}
