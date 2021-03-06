<?php










namespace Symfony\Component\Finder\Adapter;

@trigger_error('The '.__NAMESPACE__.'\GnuFindAdapter class is deprecated since Symfony 2.8 and will be removed in 3.0. Use directly the Finder class instead.', E_USER_DEPRECATED);

use Symfony\Component\Finder\Expression\Expression;
use Symfony\Component\Finder\Iterator\SortableIterator;
use Symfony\Component\Finder\Shell\Command;
use Symfony\Component\Finder\Shell\Shell;








class GnuFindAdapter extends AbstractFindAdapter
{



public function getName()
{
return 'gnu_find';
}




protected function buildFormatSorting(Command $command, $sort)
{
switch ($sort) {
case SortableIterator::SORT_BY_NAME:
$command->ins('sort')->add('| sort');

return;
case SortableIterator::SORT_BY_TYPE:
$format = '%y';
break;
case SortableIterator::SORT_BY_ACCESSED_TIME:
$format = '%A@';
break;
case SortableIterator::SORT_BY_CHANGED_TIME:
$format = '%C@';
break;
case SortableIterator::SORT_BY_MODIFIED_TIME:
$format = '%T@';
break;
default:
throw new \InvalidArgumentException(sprintf('Unknown sort options: %s.', $sort));
}

$command
->get('find')
->add('-printf')
->arg($format.' %h/%f\\n')
->add('| sort | cut')
->arg('-d ')
->arg('-f2-')
;
}




protected function canBeUsed()
{
return Shell::TYPE_UNIX === $this->shell->getType() && parent::canBeUsed();
}




protected function buildFindCommand(Command $command, $dir)
{
return parent::buildFindCommand($command, $dir)->add('-regextype posix-extended');
}




protected function buildContentFiltering(Command $command, array $contains, $not = false)
{
foreach ($contains as $contain) {
$expr = Expression::create($contain);


$command
->add('| xargs -I{} -r grep -I')
->add($expr->isCaseSensitive() ? null : '-i')
->add($not ? '-L' : '-l')
->add('-Ee')->arg($expr->renderPattern())
->add('{}')
;
}
}
}
