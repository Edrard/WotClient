<?php

declare(strict_types=1);

namespace edrard\WotClient;

/** Classifies the WG status only; payload interpretation belongs to consumers. */
final class ResponseValidator
{
    /**
     * @param array<string, mixed> $endpoint
     * @param array<array-key, mixed> $envelope
     */
    public function validate(array $endpoint, array $envelope): ApiResult
    {
        if (($envelope['status'] ?? null) === 'error') {
            $error = $envelope['error'] ?? null;
            if (!is_array($error)) {
                throw new InvalidResponseException();
            }
            $code = $error['code'] ?? null;
            $message = $error['message'] ?? null;
            $safeMessage = in_array($message, [
                'INVALID_IP_ADDRESS', 'INVALID_APPLICATION_ID', 'APPLICATION_IS_BLOCKED',
                'REQUEST_LIMIT_EXCEEDED', 'SOURCE_NOT_AVAILABLE',
            ], true) ? $message : null;

            throw new ClientException('WG rejected the request.', is_int($code) ? $code : null, providerMessage: $safeMessage);
        }
        if (($envelope['status'] ?? null) !== 'ok') {
            throw new InvalidResponseException();
        }

        $data = $envelope['data'] ?? null;
        if ($data !== null && !is_array($data)) {
            throw new InvalidResponseException();
        }

        return new ApiResult($data, is_array($envelope['meta'] ?? null) ? $envelope['meta'] : [], $envelope);
    }
}
