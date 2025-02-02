..  include:: /Includes.rst.txt
..  index::
    Extension development; Resources
    Folder; Resources
..  _extension-files-Resources:
..  _extension-Resources:

===========
`Resources`
===========

Contains the sub folders :file:`Public/` and :file:`Private/`, which
contain resources, possibly in further subfolders.

Only files in the folder :file:`Public/` should be publicly accessible.
All resources that only get accessed by the web server
(templates, language files, etc.) go to the folder :file:`Private/`.

..  note::
    Non–TYPO3 files such as third party JavaScript libraries are commonly stored
    in this folder.

    TYPO3 is licensed under GPL version 2 or any later version. Any non–TYPO3
    code must be compatible with GPL version 2 or any later version.

..  toctree::
    :titlesonly:
    :glob:

    */Index
