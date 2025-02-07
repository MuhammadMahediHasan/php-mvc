<?php

define("BASE_PATH", realpath(__DIR__ . '/../../'));

const HTTP_OK = 200;
const HTTP_CREATED = 201;
const HTTP_NOT_FOUND = 404;
const HTTP_INTERNAL_SERVER_ERROR = 500;
const UNPROCESSABLE_ENTITY = 422;

$domSections = [];

function startSection($name): void
{
    global $domSections;
    ob_start();
    $domSections[$name] = '';
}

function endSection(): void
{
    global $domSections;
    $lastKey = array_key_last($domSections);
    $domSections[$lastKey] = ob_get_clean();
}

function yieldSection($name) {
    global $domSections;
    return $domSections[$name] ?? '';
}

if (!function_exists('asset')) {
    function asset($path): string
    {
        return url("public/$path");
    }
}

if (!function_exists('view')) {
    function view($path): string
    {
        return BASE_PATH . "/resource/views/$path";
    }
}

if (!function_exists('url')) {
    function url($path = ''): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $script = $_SERVER['SCRIPT_NAME'];
        $url = str_replace(basename($script), "", $script);

        return $protocol . "://" . $host . $url . $path;
    }
}

if (!function_exists('config')) {
    function config($key)
    {
        $config = require BASE_PATH . "/config/config.php";

        return $config[$key] ?? null;
    }
}

if (!function_exists('successResponse')) {
    function successResponse($data, $status = null): bool|string
    {
        $status = $status ?: HTTP_OK;
        http_response_code($status);

        return json_encode(
            array_merge($data, ['status' => $status])
        );
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($data, $status = null): bool|string
    {
        $status = $status ?: HTTP_INTERNAL_SERVER_ERROR;
        http_response_code($status);

        return json_encode(
            array_merge($data, ['status' => $status])
        );
    }
}
