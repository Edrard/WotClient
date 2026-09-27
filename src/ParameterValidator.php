<?php

declare(strict_types=1);

namespace edrard\WotClient;

use InvalidArgumentException;
use DateTimeImmutable;
use Exception;

final class ParameterValidator
{
    /**
     * @param array<string, mixed> $endpoint
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function validate(array $endpoint, #[\SensitiveParameter] array $parameters): array
    {
        $schemas = $endpoint['parameters'];
        foreach ($parameters as $name => $value) {
            if (!isset($schemas[$name]) || $name === 'access_token' || $name === 'application_id') {
                throw new InvalidArgumentException('Unknown or reserved WoT parameter.');
            }
            if ($value === null || $value === []) {
                unset($parameters[$name]);
                continue;
            }
            $schema = $schemas[$name];
            $list = str_contains($schema['type'], ', list');
            $items = $list ? (is_array($value) ? array_values($value) : [$value]) : [$value];
            if (!$list && is_array($value)) {
                throw new InvalidArgumentException('Expected a scalar parameter: '.$name);
            }
            foreach ($items as $item) {
                $numeric = $schema['type'] === 'numeric' || $schema['type'] === 'numeric, list';
                if ($numeric) {
                    if (!is_int($item)) {
                        throw new InvalidArgumentException('Expected an integer parameter: '.$name);
                    }
                    $minimum = $schema['min'] ?? ((str_ends_with($name, '_id') || in_array($name, ['page_no', 'limit', 'tier', 'reserve_level'], true)) ? 1 : 0);
                    if ($item < $minimum || ($schema['max'] !== null && $item > $schema['max'])) {
                        throw new InvalidArgumentException('Parameter is outside its allowed range: '.$name);
                    }
                } elseif ($schema['type'] === 'timestamp/date') {
                    if ((!is_int($item) || $item < 1) && (!is_string($item) || !preg_match('/^\d{4}-\d{2}-\d{2}(?:T\d{2}:\d{2}:\d{2}(?:Z|[+-]\d{2}:\d{2})?)?$/D', $item))) {
                        throw new InvalidArgumentException('Expected a timestamp or ISO date: '.$name);
                    }
                    if (is_string($item)) {
                        try {
                            new DateTimeImmutable($item);
                            $errors = DateTimeImmutable::getLastErrors();
                        } catch (Exception) {
                            throw new InvalidArgumentException('Invalid ISO date.');
                        }
                        if ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0)) {
                            throw new InvalidArgumentException('Invalid ISO date.');
                        }
                    }
                } elseif (!is_string($item) || trim($item) === '' || preg_match('/[\x00-\x1f\x7f]/', $item)) {
                    throw new InvalidArgumentException('Expected a non-empty string parameter: '.$name);
                }
                if ($schema['choices'] !== [] && !in_array((string) $item, $schema['choices'], true)) {
                    throw new InvalidArgumentException('Unsupported parameter value: '.$name);
                }
                if (is_string($item) && (($schema['minLength'] !== null && strlen($item) < $schema['minLength']) || ($schema['maxLength'] !== null && strlen($item) > $schema['maxLength']))) {
                    throw new InvalidArgumentException('Invalid parameter length: '.$name);
                }
                if ($name === 'fields' && !preg_match('/^-?[a-zA-Z0-9_]+(?:\.[a-zA-Z0-9_]+)*$/D', (string) $item)) {
                    throw new InvalidArgumentException('Invalid field selector.');
                }
            }
            if ($list) {
                $items = array_values(array_unique($items, SORT_REGULAR));
                if ($name !== $endpoint['batchParameter'] && $schema['maxItems'] !== null && count($items) > $schema['maxItems']) {
                    throw new InvalidArgumentException('Parameter list is too large: '.$name);
                }
                $parameters[$name] = $items;
            }
        }
        foreach ($schemas as $name => $schema) {
            if ($schema['required'] && $name !== 'access_token' && !array_key_exists($name, $parameters)) {
                throw new InvalidArgumentException('Required parameter is missing: '.$name);
            }
        }
        if ($endpoint['path'] === 'account/list') {
            $type = $parameters['type'] ?? 'startswith';
            $terms = $type === 'exact' ? explode(',', $parameters['search']) : [$parameters['search']];
            if (count($terms) > 100) {
                throw new InvalidArgumentException('Too many exact player names.');
            }
            foreach ($terms as $term) {
                $length = strlen($term);
                if ($length < ($type === 'exact' ? 1 : 3) || $length > 24) {
                    throw new InvalidArgumentException('Invalid player search length.');
                }
            }
        }
        if (isset($parameters['in_garage']) && empty($endpoint['hasToken'])) {
            throw new InvalidArgumentException('Garage filtering requires an access token.');
        }
        return $parameters;
    }
}
