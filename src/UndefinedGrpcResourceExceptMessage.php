<?php
declare(strict_types=1);

namespace Fangx\Resource;

use Fangx\Resource\Grpc\GrpcResource;

class UndefinedGrpcResourceExceptMessage extends \Exception
{
    public $resource;

    public function __construct(GrpcResource $resource)
    {
        $this->resource = $resource;

        $message = sprintf("You must override except() and return the message class that for this resource in class [%s].", get_class($resource));

        parent::__construct($message, 500);
    }
}
