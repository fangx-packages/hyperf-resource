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

# source: Grpc/grpc.proto

namespace GPBMetadata\Grpc;

class Grpc
{
    public static $is_initialized = false;

    public static function initOnce()
    {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
            return;
        }
        $pool->internalAddGeneratedFile(hex2bin(
            '0ae7010a0f477270632f677270632e70726f746f12046772706322230a06' .
            '486955736572120c0a046e616d65180120012809120b0a03736578180220' .
            '01280522360a0748695265706c79120f0a076d6573736167651801200128' .
            '09121a0a047573657218022001280b320c2e677270632e48695573657222' .
            '380a08416c6c5265706c79120f0a076d657373616765180120012809121b' .
            '0a05757365727318022003280b320c2e677270632e486955736572322f0a' .
            '02686912290a0873617948656c6c6f120c2e677270632e4869557365721a' .
            '0d2e677270632e48695265706c792200620670726f746f33'
        ), true);

        static::$is_initialized = true;
    }
}
