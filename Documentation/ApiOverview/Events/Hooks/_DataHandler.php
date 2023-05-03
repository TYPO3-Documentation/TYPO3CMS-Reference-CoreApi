<?php

namespace TYPO3\CMS\Core\DataHandling;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataHandler
{
    protected function prepareCacheFlush($table, $uid, $pid)
    {
        // do something [...]
        // Call post processing function for clear-cache:
        $_params = ['table' => $table, 'uid' => $uid/*...*/];
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'] ?? [] as $_funcRef) {
            GeneralUtility::callUserFunction($_funcRef, $_params, $this);
        }
    }
}
