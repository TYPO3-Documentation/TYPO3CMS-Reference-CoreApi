.. include:: ../../../../Includes.txt


.. _SendRecoveryEmailEvent:


======================
SendRecoveryEmailEvent
======================

Event that contains the email to be sent to the user when they request a new password.
Additional validation can happen here.


API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getUserInformation()
   :sep:`|` :aspect:`ReturnType:` array
   :sep:`|`

   |nbsp|

getEmail()
   :sep:`|` :aspect:`ReturnType:` :php:`\Symfony\Component\Mime\Email`
   :sep:`|`

   |nbsp|

