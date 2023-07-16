<?php

declare(strict_types=1);

use Cashbox\Core\Concerns\Migrations\PrivateMigration;

return new class extends PrivateMigration {
    public function up(): void
    {
        if ($this->doesntSame() && $this->exists()) {
            $this->rename();
        }
    }

    protected function rename(): void
    {
        $this->connection()->rename($this->detectName(), $this->table());
    }

    protected function exists(): bool
    {
        return $this->connection()->hasTable($this->detectName());
    }

    protected function doesntSame(): bool
    {
        return $this->detectName() !== $this->table();
    }

    protected function detectName(): string
    {
        $old = config('cashier.details.table');
        $new = config('cashbox.details.table');

        if ($old) {
            return $old;
        }

        if ($new && $new !== $this->table()) {
            return $new;
        }

        return 'cashier_details';
    }
};
