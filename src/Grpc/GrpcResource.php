<?php
declare(strict_types=1);

namespace Fangx\Resource\Grpc;

use Fangx\Resource\MessageResource;
use Fangx\Resource\Json\JsonResource;
use Fangx\Resource\UndefinedGrpcResourceExceptMessage;

class GrpcResource extends JsonResource implements MessageResource
{
    public function expect(): string
    {
        throw new UndefinedGrpcResourceExceptMessage($this);
    }
}
