.. include:: ../../Includes.txt


.. _staging-servers:

Use staging servers for developments and tests
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

During the development phase of a project and also after the launch of
a TYPO3 site as ongoing maintenance work, it is often required to test
if new or updated extensions, PHP, TypoScript or other code meets the
requirements.

A website that is already "live" and publicly accessible should not be
used for these purposes. New developments and tests should be done on
so called "staging servers" which are used as a temporary stage and
could be messed up without an impact on the "live" site. Only
relevant/required, tested and reviewed clean code should then be
implemented on the production site.

This is not security-related on the first view but "tests" are often
grossly negligent implemented, without security aspects in mind.
Staging servers also help keeping the production sites slim and clean
and reduce maintenance work (e.g. updating extensions which are not in
use).

