.. include:: /Includes.rst.txt
.. index:: Crowdin; Online translation
.. _crowdin-crowdin-translation:

===============================
Online translation with Crowdin
===============================

.. tip::
    The Crowdin solution provide you with a well written and extended knowledge base on all issues concerning
    how to use the platform. You'll find it here: `<https://support.crowdin.com/>`__.

Getting started
===============

If you want to participate, it only takes a few easy steps to get started:

1. Create an account at Crowdin: `<https://accounts.crowdin.com/register>`__
2. Either find a TYPO3-project or go straight to TYPO3-core (`<https://crowdin.com/project/typo3-cms>`__). There is also a list of extensions available for translation at the `TYPO3 Crowdin Bridge <https://localize.typo3.org/fileadmin/ter/status.html>`__
3. Join the project
4. Select your preferred language
5. Start translation

Using Crowdin is free for Open Source projects. For private projects, Crowdin's pricing model is based on projects and not on individual users.

Teams and roles
===============

When you sign up for an account at Crowdin for the first time, you will be awarded with the role ‘Translator’ and you can begin translating.
Find the project by searching and click on the ‘Join’ button. Click on the language/flag you want to translate. Go translate!

All translated strings will be considered as translated but not proofed. When the strings have been proofed by team members with the role ‘Proofreader’,
the translation will be available for all TYPO3 instances through the “Managing Language Packs” in TYPO3 backend.

The language files in Core
==========================

In Crowdin, Core is divided up in sys-extensions and their underlying language files.
Each sys extension contains one or more files and the structure reflects the real structure, but only with the .xlf-files

While you translate an xlf-file, Crowdin supports you with valuable information.

- You get a clear overview on the progress. A grey bar means that work needs to be done, the blue bar shows how many words
  have been translated and the green bar shows how many words have been approved.
- The system offers you suggestions on terms and translations from the Translation Memory (TM) and Machine Translation (MT)
- You can sort and order the labels in different ways; show only untranslated, unresolved, commented, and so on. And all labels too of course.
- You can start discussions about a specific string
- You can search TM
- You can improve TM by adding new terms.
- You can also easily get in contact with the language manager and team members.

Preconditions
=============

You need a detailed understanding of how TYPO3 works. You have prefereably worked with TYPO3 for some years as developer, administrator,
integrator or senior editor. You know your way around in the backend and you are familiar with most of the functionality and features.
If you are more focused in translation extensions, you’ll need to understand all the parts of the extension before you start translating.

What skills are needed
======================

You need to be bilingual: Fluent in both English and the language you will translate into. It would be hard work if you only had casual knowledge of the target language or English. And we would (probably) end up with confusing localization.

A good understanding of how language is constructed in terms of nouns, verbs, punctation and grammar in general will be necessary.

How to create (good) translations
=================================

1. Be true to the source labels you work with. Given that the developer of the code, who made the English text, understands the functionality best, please try to translate the meaning of the sentences.

2. Translate organically, not literally. The structure or your target language is important. English often has a different structure and tone, so you must adapt the equal text but the equivalent. So please don’t replicate but replace.

3. Use the same level of formality. The cultural context can be very different from different languages. What goes in English might be way too informal in your language and vice versa. Try to find a good level of (in)formality and stick to it. And be open to discuss it with your fellow team translators.

4. Look into other localized projects in your language. There are tons of open source projects being translated, also into your language. Be curious and look at how the localization is done – there might be things to learn and adapt.

5. Be consistent. Localization of high quality is characterised by the consistency. Make extensive use of the terms and glossary.

6. Make careful use of machine translation. It’s tempting but dangerous to do a quick translation with one of the common machine translation tools and it can sometimes help you getting a deeper understanding of the meaning of a text.
But very often a machine translated text breaks all of the rules above, unless you carefully rework the text afterwards.

7. Work together. As in all other aspects of Open Source, things get so much better, if we work together. So, reach out for help if you get stuck. Or offer your knowledge if someone ask.
Crowdin offers a good platform for cooperating with your team translators, and please join the `Translation Slack channel <https://typo3.slack.com/archives/C032FRT0W>`__.

Translation styles
==================

In general and where it makes sense, we follow the style guide from the Content Team: `<https://typo3.org/community/teams/content/writing-style-guide/>`__

In the future (when translation teams start getting bigger), it might be a good idea to develop local style guides.

Links
=====

There are many good resources when it comes to translation, language, dictionaries, etc. Feel free to suggest your favorite websites, when you work with language.

`<https://iate.europa.eu/home>`__

`<https://gengo.com/translators/resources/>`__

`<https://docs.microsoft.com/style-guide>`__

FAQ
===

Should I localize both 10.4 and master?
---------------------------------------

Master is the leading version. Every string which exists in the previous version as well is automatically filled during the export and only needs to be localized if it is different in the previous version.

Strings are translated, but when are they taken into account and available for download?
----------------------------------------------------------------------------------------

As soon as a string is proofread, it will be taken into account at the next export.

How can I be sure what way a word, term or sting is to be translated?
---------------------------------------------------------------------

There are several ways to get help: In the left panel you can either search the translation memory (TM) or the term base. You can also drop a comment to start a discussion or ask for advice.

Where do I meet all the other translators?
------------------------------------------

There is a good chance to find help and endorsement in the TYPO3 Slack
workspace. Try the `Translation Slack channel #typo3-translations <https://typo3.slack.com/archives/C032FRT0W>`__.
