<?php










namespace Symfony\Component\Console\Input;

use Symfony\Component\Console\Exception\RuntimeException;


























class ArgvInput extends Input
{
private $tokens;
private $parsed;





public function __construct(array $argv = null, InputDefinition $definition = null)
{
if (null === $argv) {
$argv = $_SERVER['argv'];
}


array_shift($argv);

$this->tokens = $argv;

parent::__construct($definition);
}

protected function setTokens(array $tokens)
{
$this->tokens = $tokens;
}




protected function parse()
{
$parseOptions = true;
$this->parsed = $this->tokens;
while (null !== $token = array_shift($this->parsed)) {
if ($parseOptions && '' == $token) {
$this->parseArgument($token);
} elseif ($parseOptions && '--' == $token) {
$parseOptions = false;
} elseif ($parseOptions && 0 === strpos($token, '--')) {
$this->parseLongOption($token);
} elseif ($parseOptions && '-' === $token[0] && '-' !== $token) {
$this->parseShortOption($token);
} else {
$this->parseArgument($token);
}
}
}






private function parseShortOption($token)
{
$name = substr($token, 1);

if (\strlen($name) > 1) {
if ($this->definition->hasShortcut($name[0]) && $this->definition->getOptionForShortcut($name[0])->acceptValue()) {

$this->addShortOption($name[0], substr($name, 1));
} else {
$this->parseShortOptionSet($name);
}
} else {
$this->addShortOption($name, null);
}
}








private function parseShortOptionSet($name)
{
$len = \strlen($name);
for ($i = 0; $i < $len; ++$i) {
if (!$this->definition->hasShortcut($name[$i])) {
$encoding = mb_detect_encoding($name, null, true);
throw new RuntimeException(sprintf('The "-%s" option does not exist.', false === $encoding ? $name[$i] : mb_substr($name, $i, 1, $encoding)));
}

$option = $this->definition->getOptionForShortcut($name[$i]);
if ($option->acceptValue()) {
$this->addLongOption($option->getName(), $i === $len - 1 ? null : substr($name, $i + 1));

break;
} else {
$this->addLongOption($option->getName(), null);
}
}
}






private function parseLongOption($token)
{
$name = substr($token, 2);

if (false !== $pos = strpos($name, '=')) {
if (0 === \strlen($value = substr($name, $pos + 1))) {
array_unshift($this->parsed, null);
}
$this->addLongOption(substr($name, 0, $pos), $value);
} else {
$this->addLongOption($name, null);
}
}








private function parseArgument($token)
{
$c = \count($this->arguments);


if ($this->definition->hasArgument($c)) {
$arg = $this->definition->getArgument($c);
$this->arguments[$arg->getName()] = $arg->isArray() ? array($token) : $token;


} elseif ($this->definition->hasArgument($c - 1) && $this->definition->getArgument($c - 1)->isArray()) {
$arg = $this->definition->getArgument($c - 1);
$this->arguments[$arg->getName()][] = $token;


} else {
$all = $this->definition->getArguments();
if (\count($all)) {
throw new RuntimeException(sprintf('Too many arguments, expected arguments "%s".', implode('" "', array_keys($all))));
}

throw new RuntimeException(sprintf('No arguments expected, got "%s".', $token));
}
}









private function addShortOption($shortcut, $value)
{
if (!$this->definition->hasShortcut($shortcut)) {
throw new RuntimeException(sprintf('The "-%s" option does not exist.', $shortcut));
}

$this->addLongOption($this->definition->getOptionForShortcut($shortcut)->getName(), $value);
}









private function addLongOption($name, $value)
{
if (!$this->definition->hasOption($name)) {
throw new RuntimeException(sprintf('The "--%s" option does not exist.', $name));
}

$option = $this->definition->getOption($name);


if (!isset($value[0])) {
$value = null;
}

if (null !== $value && !$option->acceptValue()) {
throw new RuntimeException(sprintf('The "--%s" option does not accept a value.', $name));
}

if (null === $value && $option->acceptValue() && \count($this->parsed)) {


$next = array_shift($this->parsed);
if (isset($next[0]) && '-' !== $next[0]) {
$value = $next;
} elseif (empty($next)) {
$value = null;
} else {
array_unshift($this->parsed, $next);
}
}

if (null === $value) {
if ($option->isValueRequired()) {
throw new RuntimeException(sprintf('The "--%s" option requires a value.', $name));
}

if (!$option->isArray()) {
$value = $option->isValueOptional() ? $option->getDefault() : true;
}
}

if ($option->isArray()) {
$this->options[$name][] = $value;
} else {
$this->options[$name] = $value;
}
}




public function getFirstArgument()
{
foreach ($this->tokens as $token) {
if ($token && '-' === $token[0]) {
continue;
}

return $token;
}
}




public function hasParameterOption($values)
{
$values = (array) $values;

foreach ($this->tokens as $token) {
foreach ($values as $value) {



$leading = 0 === strpos($value, '--') ? $value.'=' : $value;
if ($token === $value || '' !== $leading && 0 === strpos($token, $leading)) {
return true;
}
}
}

return false;
}




public function getParameterOption($values, $default = false)
{
$values = (array) $values;
$tokens = $this->tokens;

while (0 < \count($tokens)) {
$token = array_shift($tokens);

foreach ($values as $value) {
if ($token === $value) {
return array_shift($tokens);
}



$leading = 0 === strpos($value, '--') ? $value.'=' : $value;
if ('' !== $leading && 0 === strpos($token, $leading)) {
return substr($token, \strlen($leading));
}
}
}

return $default;
}






public function __toString()
{
$self = $this;
$tokens = array_map(function ($token) use ($self) {
if (preg_match('{^(-[^=]+=)(.+)}', $token, $match)) {
return $match[1].$self->escapeToken($match[2]);
}

if ($token && '-' !== $token[0]) {
return $self->escapeToken($token);
}

return $token;
}, $this->tokens);

return implode(' ', $tokens);
}
}
