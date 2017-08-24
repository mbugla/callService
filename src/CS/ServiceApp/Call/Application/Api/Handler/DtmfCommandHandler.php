<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Application\Api\Handler;

use CS\ServiceApp\Call\Application\Api\Command\DtmfCommand;

interface DtmfCommandHandler
{
    public function handleDTMF(DtmfCommand $dtmfCommand);
}
