<?php








namespace JsonSchema\Constraints;

use JsonSchema\Entity\JsonPointer;
use JsonSchema\Rfc3339;








class FormatConstraint extends Constraint
{



public function check(&$element, $schema = null, JsonPointer $path = null, $i = null)
{
if (!isset($schema->format) || $this->factory->getConfig(self::CHECK_MODE_DISABLE_FORMAT)) {
return;
}

switch ($schema->format) {
case 'date':
if (!$date = $this->validateDateTime($element, 'Y-m-d')) {
$this->addError($path, sprintf('Invalid date %s, expected format YYYY-MM-DD', json_encode($element)), 'format', array('format' => $schema->format));
}
break;

case 'time':
if (!$this->validateDateTime($element, 'H:i:s')) {
$this->addError($path, sprintf('Invalid time %s, expected format hh:mm:ss', json_encode($element)), 'format', array('format' => $schema->format));
}
break;

case 'date-time':
if (null === Rfc3339::createFromString($element)) {
$this->addError($path, sprintf('Invalid date-time %s, expected format YYYY-MM-DDThh:mm:ssZ or YYYY-MM-DDThh:mm:ss+hh:mm', json_encode($element)), 'format', array('format' => $schema->format));
}
break;

case 'utc-millisec':
if (!$this->validateDateTime($element, 'U')) {
$this->addError($path, sprintf('Invalid time %s, expected integer of milliseconds since Epoch', json_encode($element)), 'format', array('format' => $schema->format));
}
break;

case 'regex':
if (!$this->validateRegex($element)) {
$this->addError($path, 'Invalid regex format ' . $element, 'format', array('format' => $schema->format));
}
break;

case 'color':
if (!$this->validateColor($element)) {
$this->addError($path, 'Invalid color', 'format', array('format' => $schema->format));
}
break;

case 'style':
if (!$this->validateStyle($element)) {
$this->addError($path, 'Invalid style', 'format', array('format' => $schema->format));
}
break;

case 'phone':
if (!$this->validatePhone($element)) {
$this->addError($path, 'Invalid phone number', 'format', array('format' => $schema->format));
}
break;

case 'uri':
if (null === filter_var($element, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE)) {
$this->addError($path, 'Invalid URL format', 'format', array('format' => $schema->format));
}
break;

case 'uriref':
case 'uri-reference':
if (null === filter_var($element, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE)) {



if (substr($element, 0, 2) === '//') { 
$validURL = filter_var('scheme:' . $element, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
} elseif (substr($element, 0, 1) === '/') { 
$validURL = filter_var('scheme://host' . $element, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
} elseif (strlen($element)) { 
$pathParts = explode('/', $element, 2);
if (strpos($pathParts[0], ':') !== false) {
$validURL = null;
} else {
$validURL = filter_var('scheme://host/' . $element, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
}
} else {
$validURL = null;
}
if ($validURL === null) {
$this->addError($path, 'Invalid URL format', 'format', array('format' => $schema->format));
}
}
break;

case 'email':
$filterFlags = FILTER_NULL_ON_FAILURE;
if (defined('FILTER_FLAG_EMAIL_UNICODE')) {

$filterFlags |= constant('FILTER_FLAG_EMAIL_UNICODE'); 
}
if (null === filter_var($element, FILTER_VALIDATE_EMAIL, $filterFlags)) {
$this->addError($path, 'Invalid email', 'format', array('format' => $schema->format));
}
break;

case 'ip-address':
case 'ipv4':
if (null === filter_var($element, FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE | FILTER_FLAG_IPV4)) {
$this->addError($path, 'Invalid IP address', 'format', array('format' => $schema->format));
}
break;

case 'ipv6':
if (null === filter_var($element, FILTER_VALIDATE_IP, FILTER_NULL_ON_FAILURE | FILTER_FLAG_IPV6)) {
$this->addError($path, 'Invalid IP address', 'format', array('format' => $schema->format));
}
break;

case 'host-name':
case 'hostname':
if (!$this->validateHostname($element)) {
$this->addError($path, 'Invalid hostname', 'format', array('format' => $schema->format));
}
break;

default:






break;
}
}

protected function validateDateTime($datetime, $format)
{
$dt = \DateTime::createFromFormat($format, $datetime);

if (!$dt) {
return false;
}

if ($datetime === $dt->format($format)) {
return true;
}





if ((strpos('u', $format) !== -1) && (preg_match('/\.\d+Z$/', $datetime))) {
return true;
}

return false;
}

protected function validateRegex($regex)
{
return false !== @preg_match('/' . $regex . '/u', '');
}

protected function validateColor($color)
{
if (in_array(strtolower($color), array('aqua', 'black', 'blue', 'fuchsia',
'gray', 'green', 'lime', 'maroon', 'navy', 'olive', 'orange', 'purple',
'red', 'silver', 'teal', 'white', 'yellow'))) {
return true;
}

return preg_match('/^#([a-f0-9]{3}|[a-f0-9]{6})$/i', $color);
}

protected function validateStyle($style)
{
$properties = explode(';', rtrim($style, ';'));
$invalidEntries = preg_grep('/^\s*[-a-z]+\s*:\s*.+$/i', $properties, PREG_GREP_INVERT);

return empty($invalidEntries);
}

protected function validatePhone($phone)
{
return preg_match('/^\+?(\(\d{3}\)|\d{3}) \d{3} \d{4}$/', $phone);
}

protected function validateHostname($host)
{
$hostnameRegex = '/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/i';

return preg_match($hostnameRegex, $host);
}
}
