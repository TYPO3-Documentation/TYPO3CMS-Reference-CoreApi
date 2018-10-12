.. include:: ../../Includes.txt


.. _encryption-key:

Encryption key
^^^^^^^^^^^^^^

The encryption key can be found in the Install Tool (section "Basic
Configuration" and "All Configuration"). This string, usually a
hexadecimal hash value of 96 characters, is used as the "salt" for
various kinds of encryption, CRC checksums and validations (e.g. for
the "cHash"). Therefore, a change of this value invalidates temporary
information, cache content, etc. and you should clear all caches after
you changed this value in order to force the rebuild of this data with
the new encryption key.

Keep in mind that this string is security-related and you should keep
it in a safe place.

