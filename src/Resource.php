<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://github.com/fangx-packages/hyperf-resource
 * @document https://github.com/fangx-packages/hyperf-resource/blob/master/README.md
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 */

namespace Fangx\Resource;

use Fangx\Resource\Response\Response;
use Hyperf\HttpMessage\Base\Response as HttpResponse;
use Hyperf\Utils\Traits\Macroable;

class Resource extends HttpResponse
{
    use Macroable;

    public function toResponse()
    {
        return (new Response($this))->toResponse();
    }
}
