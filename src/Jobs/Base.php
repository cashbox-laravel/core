<?php

namespace Helldar\Cashier\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Base implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
}
