:navigation-title: Webhooks and reactions

..  include:: /Includes.rst.txt
..  index::
    Webhooks
    Reactions
.. _webhooks:

=======================================================
Webhooks and reactions: Integration of external systems
=======================================================

..  versionchanged:: 14.0
    The backend module for the reactions was moved to
    :guilabel:`System > Integrations > Reactions` and the module for the webhooks
    to :guilabel:`System > Integrations > Webhooks`

A webhook is an automated message sent from one application to another via HTTP.
It is defined as an authorized POST or GET request to a defined URL. For
example, a webhook can be used to send a notification to a Slack channel when a
new page is created in TYPO3.

TYPO3 supports incoming and outgoing webhooks:

*   The system extension :doc:`Reactions <ext_reactions:Index>` provides the
    functionality to receive webhooks in TYPO3 from third-party system.
*   The system extension :ref:`Webhooks <ext_core:feature-99629-1674550092>`
    provides the possibility to send webhooks from TYPO3 to third-party
    systems.

Have a look at the linked documentation for more details.
