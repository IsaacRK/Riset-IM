<?php










namespace Symfony\Component\Console\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;






class CommandTester
{
private $command;
private $input;
private $output;
private $statusCode;

public function __construct(Command $command)
{
$this->command = $command;
}















public function execute(array $input, array $options = array())
{


if (!isset($input['command'])
&& (null !== $application = $this->command->getApplication())
&& $application->getDefinition()->hasArgument('command')
) {
$input = array_merge(array('command' => $this->command->getName()), $input);
}

$this->input = new ArrayInput($input);
if (isset($options['interactive'])) {
$this->input->setInteractive($options['interactive']);
}

$this->output = new StreamOutput(fopen('php://memory', 'w', false));
$this->output->setDecorated(isset($options['decorated']) ? $options['decorated'] : false);
if (isset($options['verbosity'])) {
$this->output->setVerbosity($options['verbosity']);
}

return $this->statusCode = $this->command->run($this->input, $this->output);
}








public function getDisplay($normalize = false)
{
rewind($this->output->getStream());

$display = stream_get_contents($this->output->getStream());

if ($normalize) {
$display = str_replace(PHP_EOL, "\n", $display);
}

return $display;
}






public function getInput()
{
return $this->input;
}






public function getOutput()
{
return $this->output;
}






public function getStatusCode()
{
return $this->statusCode;
}
}
