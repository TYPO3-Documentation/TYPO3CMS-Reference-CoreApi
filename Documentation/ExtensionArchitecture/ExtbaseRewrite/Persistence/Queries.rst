:navigation-title: Queries

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Queries
..  _extbase-persistence-queries:

==================================
Querying the database with Extbase
==================================

..  include:: /ExtensionArchitecture/ExtbaseRewrite/_wip.rst.txt

..  Cover _isNew() in the context of persistAll()-before-redirect: the method returns true when
..  getUid() is null (object not yet persisted). Show it next to the persistAll() example so
..  readers understand when to check it and why the UID is unavailable before flush.
..
..  Cover the full storagePid resolution order (plugin TS > global TS > page module) and the
..  persistence.recursive setting (must be configured explicitly; without it only the configured
..  page is searched, not subfolders; setting it too broadly can pick up records from unintended
..  subpages). Source to harvest and fact-check against current TYPO3 v13/v14 source:
..  https://www.derhansen.de/2016/02/how-extbase-determines-storagepid.html
