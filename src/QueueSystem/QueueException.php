<?php


namespace Tutorial\QueueSystem;


/** @noinspection PhpUndefinedClassInspection */
class QueueException extends \Exception {
	const INVALID_VIRTUAL_HOST = 'Invalid Virtual Host';
	const EMPTY_ROUTING_KEY    = 'Empty routing key';
}