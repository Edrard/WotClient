<?php

declare(strict_types=1);

namespace edrard\WotClient;

final class ResponseValidator
{
    /**
     * Validate the envelope and documented fields that are actually present, including nested rows.
     * Provider structures remain arrays; unknown fields are preserved.
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
            throw new ClientException('WG rejected the request.', is_int($code) ? $code : null);
        }
        if (($envelope['status'] ?? null) !== 'ok' || !array_key_exists('data', $envelope)
            || ($envelope['data'] !== null && !is_array($envelope['data']))
            || (array_key_exists('meta', $envelope) && !is_array($envelope['meta']))) {
            throw new InvalidResponseException();
        }
        $data = $envelope['data'];
        if ($data !== null) {
            if ($endpoint['layout'] === 'object') {
                $this->record($data, $endpoint['fields']);
            } else {
                foreach ($data as $value) {
                    if ($value === null) {
                        continue;
                    }
                    if (!is_array($value)) {
                        throw new InvalidResponseException();
                    }
                    if ($endpoint['layout'] === 'nestedList') {
                        foreach ($value as $record) {
                            if (!is_array($record)) {
                                throw new InvalidResponseException();
                            }
                            $this->record($record, $endpoint['fields']);
                        }
                    } else {
                        $this->record($value, $endpoint['fields']);
                    }
                }
            }
        }
        return new ApiResult($data, $envelope['meta'] ?? []);
    }

    /**
     * @param array<array-key, mixed> $record
     * @param array<string, string> $fields
     */
    private function record(array $record, array $fields): void
    {
        foreach ($fields as $name => $type) {
            $this->field($record, explode('.', $name), $type);
        }
    }

    /**
     * @param array<array-key, mixed> $container
     * @param non-empty-list<string> $path
     */
    private function field(array $container, array $path, string $type, bool $rows = false): void
    {
        $name = $path[0];
        if (!array_key_exists($name, $container)) {
            if (!$rows) {
                return;
            }
            // Documented block headers may represent lists or ID-indexed collections.
            foreach ($container as $row) {
                if (is_array($row)) {
                    $this->field($row, $path, $type);
                }
            }
            return;
        }
        $value = $container[$name];
        if ($value === null) {
            return;
        }
        if (count($path) > 1) {
            if (!is_array($value)) {
                throw new InvalidResponseException();
            }
            array_shift($path);
            $this->field($value, $path, $type, true);
            return;
        }
        $valid = match ($type) {
            'numeric' => str_ends_with($name, '_id') ? is_int($value) : ((is_int($value) || is_float($value)) && is_finite((float) $value)),
            'timestamp' => is_int($value),
            'float' => (is_int($value) || is_float($value)) && is_finite((float) $value),
            'string' => is_string($value),
            'boolean' => is_bool($value),
            'block_header', 'associative array', 'object' => is_array($value),
            'list of integers', 'list of timestamps' => is_array($value) && array_is_list($value) && array_all($value, is_int(...)),
            'list of strings' => is_array($value) && array_is_list($value) && array_all($value, is_string(...)),
            default => true,
        };
        if (!$valid) {
            throw new InvalidResponseException();
        }
    }
}
