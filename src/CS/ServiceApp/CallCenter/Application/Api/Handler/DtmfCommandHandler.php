<?php
declare(strict_types=1);

namespace CS\ServiceApp\CallCenter\Application\Api\Handler;

use CS\ServiceApp\CallCenter\Application\Api\Command\DtmfCommand;

interface DtmfCommandHandler
{
    public function handleDTMF(DtmfCommand $dtmfCommand);
}
