<?php

namespace Common\Http;

class StatusService
{
    const SUCCESS = 100;
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const CONFLICT = 409;
    const EXCEPTION = 422;
    const TOO_MANY_REQUESTS = 429;

    const INTERNAL_SERVER_ERROR = 500;
    const SERVICE_UNAVAILABLE = 503;

    const STATUS_MESSAGE = [
        100 => 'SUCCESS',
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        409 => 'Conflict',
        422 => 'Exception',
        429 => 'Too Many Requests',
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
    ];
    const LABEL_SUCCESS = 'success';
    const LABEL_WARNING = 'warning';
    const LABEL_DANGER = 'error';
    const CUSTOM_EXCEPTION_MESSAGE = 'Something went wrong! please contact with support team.';

}
