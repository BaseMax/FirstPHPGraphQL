<?php
return static function(array $rootValue, array $args): string{
	return $rootValue['prefix'] . $args['message'];
};

