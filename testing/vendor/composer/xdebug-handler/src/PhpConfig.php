<?php










namespace Composer\XdebugHandler;




class PhpConfig
{





public function useOriginal()
{
$this->getDataAndReset();
return array();
}






public function useStandard()
{
if ($data = $this->getDataAndReset()) {
return array('-n', '-c', $data['tmpIni']);
}

return array();
}






public function usePersistent()
{
if ($data = $this->getDataAndReset()) {
$this->updateEnv('PHPRC', $data['tmpIni']);
$this->updateEnv('PHP_INI_SCAN_DIR', '');
}

return array();
}






private function getDataAndReset()
{
if ($data = XdebugHandler::getRestartSettings()) {
$this->updateEnv('PHPRC', $data['phprc']);
$this->updateEnv('PHP_INI_SCAN_DIR', $data['scanDir']);
}

return $data;
}







private function updateEnv($name, $value)
{
Process::setEnv($name, false !== $value ? $value : null);
}
}
