<?php

namespace Chase\Safari;

/**
 * Exactly what it sounds like.
 */
class Utils
{

    /**
     * Convert an array in to html attribute string.
     * 
     * @param array $array
     * 
     * @return string
     */
    public static function stringify(array $array): string
    {
        if (!empty($array)) {
            $keys = array_keys($array);
            $values = array_values($array);

            $markup = join('', array_map(function ($k, $v) {
                return (string)$k . '=' . var_export($v, true) . ' ';
            }, $keys, $values));
            return trim($markup);
        }
    }

    /**
     * Encodes a string with htmlentitites.
     * 
     * @param string $value
     * 
     * @return string
     */
    public static function encodeHtml(string $value): string
    {
        return htmlentities(trim($value), ENT_QUOTES, "UTF-8", false);
    }

    /**
     * Encode an associative array.
     * 
     * @param array $data
     * 
     * @return array
     */
    public static function cleanGlobal(array $data): array
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                (is_array($v)) && ($data[$k] = self::cleanGlobal($v));
                (!is_array($v)) && ($data[$k] = self::encodeHtml($v));
            }
        } else {
            $data = self::encodeHtml($data);
        }
        return $data;
    }
}
