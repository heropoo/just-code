<?php
/**
 * User: nano
 * Datetime: 2022/1/9 12:04 上午
 */

$string = '{"data": {"data123": "123"},"phone":"123fsf", "code": "xxx"}';
$map = [
    'phone' => 'pha',
    'code' => 'sure',
    'message' => 'make',
    'data' => 'want',
    'want' => 'pil',
];
$res = obfuscate_json_string($string, $map);
var_dump($res);

function obfuscate_json_string(string $string, array $map): string
{
    $dst_string = '';
    $state = 0;
    $token = '';

    for ($i = 0; $i < strlen($string); $i++) {
        if ($string[$i] === '"' && $state === 0) {   // left
            $state = 1;
            $token = '';
            $dst_string .= $string[$i];
            continue;
        }

        if ($string[$i] === '"' && $state === 1) {   // right
            $state = 2;
            $dst_string .= $string[$i];
            continue;
        }

        if ($string[$i] === ':' && $state === 2) {   // end
            $state = 0;
            $dst_string = substr($dst_string, 0, -1 - strlen($token));

            //var_dump($token);
            if (isset($map[$token])) {
                $dst_string .= $map[$token] . '"';
            } else {
                $dst_string .= $token . '"';
            }
            $dst_string .= $string[$i];
            continue;
        }

        if (!preg_match("/^[0-9a-zA-Z_]$/", $string[$i])) {
            $state = 0;
            $token = '';
        } else {
            $token .= $string[$i];
        }
        $dst_string .= $string[$i];
    }
    return $dst_string;
}

