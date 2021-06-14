<?php
return static function(array $rootValue, array $args): int{
	return $args['x'] + $args['y'];
};

