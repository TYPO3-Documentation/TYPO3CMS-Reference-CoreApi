# Contribute to TYPO3 Documentation

## Create Issues

* If you find something missing or something is wrong in this manual, you are welcome to write an issue describing the problem.
* If you can, please try to fix the problem yourself.
* For minor changes, it is not necessary to create an issue first.

## Make changes (create pull requests)

* In order to make changes on a [rendered page](https://docs.typo3.org/typo3cms/CoreApiReference/), just click on "Edit me on GitHub".
* For a step-by-step walkthrough for making a change, see [Contribute to docs.typo3.org](https://docs.typo3.org/typo3cms/HowToDocument/WritingDocsOfficial/Index.html)
* For a step-by-step walkthrough of alternative workflow, see [Local Editing and Rendering with Docker](https://docs.typo3.org/m/typo3/docs-how-to-document/main/en-us/Howto/EditLocal.html)

## (re) Generate Codesnippets
With ddev:

```
ddev start
ddev composer install
ddev exec .Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/
```

Without ddev:

```
composer install
.Build/vendor/bin/typo3 codesnippet:create Documentation/CodeSnippets/
```

## Preview rendering

You can preview the rendered result of the docs in by calling the following URL:
https://gitpod.io/#https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/tree/<your branch>

For example

* https://gitpod.io/#https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/tree/main renders the branch main
* https://gitpod.io/#https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/tree/lwolf-mychange renders branch lwolf-mychange
* https://gitpod.io/#https://github.com/linawolf/TYPO3CMS-Reference-CoreApi/tree/lwolf-mychange renders the branch lwolf-mychange in my personal fork

Hint: Use the VSStudio in browser as preview, PHPStorm is very slow

## Get help

* If you need help with contributing to the docs, see [How to get Help](https://docs.typo3.org/typo3cms/HowToDocument/HowToGetHelp.html)

# Contribute to TYPO3 Core

* See [TYPO3 Contribution Guide - Core Development](https://docs.typo3.org/typo3cms/ContributionWorkflowGuide/)

# General TYPO3 Support

If you have some general TYPO3 support questions or need help with TYPO3, please see https://typo3.org/help.
