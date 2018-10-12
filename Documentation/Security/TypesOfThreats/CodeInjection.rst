.. include:: ../../Includes.txt


.. _code-injection:

Code injection
^^^^^^^^^^^^^^

Similar to SQL injection described above, "code injection" includes
commands or files from remote instances (RFI: Remote File Inclusion)
or from the local file system (LFI: Local File Inclusion). The fetched
code becomes part of the executing script and runs in the context of
the TYPO3 site (so it has the same access privileges on a server
level). Both attacks, RFI and LFI, are often triggered by improper
verification and neutralization of user input.

Local file inclusion can lead to information disclosure (see above),
for example reveal system internal files which contain configuration
settings, passwords, encryption keys, etc.

