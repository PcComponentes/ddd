<?php
declare(strict_types=1);

namespace PcComponentes\Ddd\Util\Message\Serialization\JsonApi;

use PcComponentes\Ddd\Util\Message\Serialization\SimpleMessageSerializable;
use PcComponentes\Ddd\Util\Message\SimpleMessage;

final class SimpleMessageJsonApiSerializable implements SimpleMessageSerializable
{
    public function serialize(SimpleMessage $message)
    {
        return \json_encode(
            [
                'data' => [
                    'message_id' => $message->messageId(),
                    'type' => $message::messageName(),
                    'attributes' => $message->messagePayload(),
                ],
            ],
            \JSON_THROW_ON_ERROR,
            512,
        );
    }
}
