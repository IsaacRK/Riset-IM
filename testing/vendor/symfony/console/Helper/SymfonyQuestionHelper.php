<?php










namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;






class SymfonyQuestionHelper extends QuestionHelper
{



public function ask(InputInterface $input, OutputInterface $output, Question $question)
{
$validator = $question->getValidator();
$question->setValidator(function ($value) use ($validator) {
if (null !== $validator) {
$value = $validator($value);
} else {

if (!\is_array($value) && !\is_bool($value) && 0 === \strlen($value)) {
throw new LogicException('A value is required.');
}
}

return $value;
});

return parent::ask($input, $output, $question);
}




protected function writePrompt(OutputInterface $output, Question $question)
{
$text = OutputFormatter::escapeTrailingBackslash($question->getQuestion());
$default = $question->getDefault();

switch (true) {
case null === $default:
$text = sprintf(' <info>%s</info>:', $text);

break;

case $question instanceof ConfirmationQuestion:
$text = sprintf(' <info>%s (yes/no)</info> [<comment>%s</comment>]:', $text, $default ? 'yes' : 'no');

break;

case $question instanceof ChoiceQuestion && $question->isMultiselect():
$choices = $question->getChoices();
$default = explode(',', $default);

foreach ($default as $key => $value) {
$default[$key] = $choices[trim($value)];
}

$text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape(implode(', ', $default)));

break;

case $question instanceof ChoiceQuestion:
$choices = $question->getChoices();
$text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape(isset($choices[$default]) ? $choices[$default] : $default));

break;

default:
$text = sprintf(' <info>%s</info> [<comment>%s</comment>]:', $text, OutputFormatter::escape($default));
}

$output->writeln($text);

if ($question instanceof ChoiceQuestion) {
$width = max(array_map('strlen', array_keys($question->getChoices())));

foreach ($question->getChoices() as $key => $value) {
$output->writeln(sprintf("  [<comment>%-${width}s</comment>] %s", $key, $value));
}
}

$output->write(' > ');
}




protected function writeError(OutputInterface $output, \Exception $error)
{
if ($output instanceof SymfonyStyle) {
$output->newLine();
$output->error($error->getMessage());

return;
}

parent::writeError($output, $error);
}
}
