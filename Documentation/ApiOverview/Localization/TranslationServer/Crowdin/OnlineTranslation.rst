:navigation-title: Online translation

..  include:: /Includes.rst.txt
..  index::
    Translation
    Translation; Crowdin
    Crowdin; Online translation
..  _crowdin-crowdin-translation:

===============================
Online translation with Crowdin
===============================

..  tip::
    Crowdin provides you with a well-written and extended knowledge base on all
    questions regarding how to use the platform. See
    `Crowdin documentation <https://support.crowdin.com/>`__.

..  contents::
    :local:

..  _crowdin-crowdin-translation-getting-started:

Getting started
===============

If you want to participate, it only takes a few steps to get started:

#.  Create an account at Crowdin or connect with Social Media: `Sign Up <https://accounts.crowdin.com/register>`__
#.  Either find a TYPO3 project or go straight to TYPO3 Core
    (`Crowdin TYPO3 CMS <https://crowdin.com/project/typo3-cms>`__). There is also a list of
    extensions available for translation at 
    `Crowdin TYPO3 Status <https://localize.typo3.org/xliff/status.html>`__
#.  Join the project
#.  Select your preferred language
#.  Start translation

Using Crowdin is free for Open Source projects. For private projects, Crowdin's
pricing model is based on projects and not on individual users.

To help you get started, Tom Warwick has created a short tutorial video for you:

..  youtube:: 5TnUh0AzqHE

..  _crowdin-crowdin-translation-teams:

Teams and roles
===============

When you sign up for an account at Crowdin for the first time, you will be
awarded with the role "Translator" and you can start translating.

Find the project via the search and click on the :guilabel:`Join` button. Click
on the language/flag you want to translate. Go ahead and translate!

All translated strings are considered translated, but not proofread. When
the strings have been proofread by team members with the "Proofreader" role,
the translation will be available for all TYPO3 instances via the
"Managing Language Packs" section in the TYPO3 backend.

..  _crowdin-crowdin-translation-Core:

The language files in Core
==========================

In Crowdin, the TYPO3 Core is divided into system extensions and their
underlying language files. Each system extension contains one or more 
:ref:`XLIFF <xliff>` language files.

While you translate an XLIFF file, Crowdin supports you with valuable
information:

*   You get a clear overview on the progress. A grey bar means that work needs
    to be done. The blue bar shows how many words have been translated, and the
    green bar shows how many words have been approved.
*   The system offers you suggestions on terms and translations from the
    Translation Memory (TM) and Machine Translation (MT).
*   You can sort and order the labels in different ways:

    * show only untranslated,
    * unresolved, 
    * commented
    * and so on. 

*   You can start discussions about a specific string.
*   You can search the Translation Memory.
*   You can improve the Translation Memory by adding new terms.
*   You can easily get in contact with the language manager and team members.

..  _crowdin-crowdin-translation-preconditions:

Preconditions
=============

You need a detailed understanding of how TYPO3 works. You have preferably worked
with TYPO3 for some years as developer, administrator, integrator or senior
editor. You know your way around in the backend and you are familiar with most
of the functionality and features. If you are more focused on translating
extensions, you might need to understand some parts of the extension before
you start translating.

..  _crowdin-crowdin-translation-skills:

What skills are needed
======================

You need to be bilingual: fluent in both English and the language you are
translating into. It is unsufficient if you only have casual knowledge of the
target language or English. And we might (probably) end up with a confusing
localization.

A good understanding of how a language is constructed in terms of nouns, verbs,
punctuation and grammar in general will be necessary.

..  _crowdin-crowdin-translation-create:

How to create (good) translations
=================================

#.  Stay true to the source labels you work with. Given that the developer of
    the code, who made the English text, understands the functionality best,
    please try to translate the meaning of the sentences.

#.  Translate organically, not literally. The structure of your target language
    is important. English often has a different structure and tone. So you must
    look for the equivalent meaning in your language.

#.  Use the same level of formality. The cultural context can be very different
    from language to language. What works in English may be way far too informal
    in your language and vice versa. Try to find a good level of (in)formality
    and stick to it. And be open to discuss it with your fellow team translators.

#.  Look into other localized projects in your language. There are tons of Open
    Source projects being translated, also into your language. Be curious and
    look at how the localization is done – there might be things to learn and
    adapt.

#.  Be consistent. Localization of high quality is characterised by the
    consistency. Make extensive use of the terms and glossary.

#.  Use machine translation carefully. It is tempting but dangerous to do
    a quick translation with one of the common machine translation tools and
    sometimes it can help you to get a deeper understanding of the meaning of a
    text. But very often a machine-translated text breaks all the above rules
    unless you rework the text carefully afterwards.

#.  Work together. As in all other aspects of Open Source, things get so much
    better when we work together. So, reach out for help when you get stuck. Or
    offer your knowledge if someone asks for it. Crowdin provides a good platform
    for collaborating with your team translators, and please join the
    `Translation Slack channel #typo3-translations`_.

..  note::
    When translating into German, we prefer the informal "du" to the formal "Sie".

..  _crowdin-crowdin-translation-styles:

Translation styles
==================

In general, and where it makes sense, we follow the
:ref:`Writing Style Guide <t3content:writing-style-guide>` from the Content Team.

In the future (when translation teams start getting bigger), it might be a good
idea to develop local style guides.

..  _crowdin-crowdin-translation-proofreading:

Become a proofreader
====================
Community-driven translations form the backbone of the translation of TYPO3.
Huge thanks to all translators and proofreaders for their invaluable contributions!

Please contact the Localization Team via email at `localization@typo3.org`_ to request the role of a proofreader.

..  _localization@typo3.org: mailto:localization@typo3.org

Or join the Slack channel of the Localization Team: `#typo3-localization-team`_

.. _#typo3-localization-team: https://typo3.slack.com/archives/CR75200FL

..  _crowdin-crowdin-translation-links:

Links
=====

There are many good resources when it comes to translation, language,
dictionaries, etc. Feel free to suggest your favorite websites, when you work
with language.

*   `<https://iate.europa.eu/home>`__
*   `<https://gengo.com/translators/resources/>`__
*   `<https://docs.microsoft.com/style-guide>`__

..  _crowdin-crowdin-translation-faq:

FAQ
===

..  _crowdin-crowdin-translation-faq-versions:

Should I localize both 13.4 and main?
---------------------------------------

The main branch is the leading version. Any string that is also present in the
previous version is automatically filled during export and only needs to be
localized if it is different to the previous version.

..  _crowdin-crowdin-translation-when-download:

Strings are translated, but when are they taken into account and available for download?
----------------------------------------------------------------------------------------

As soon as a string is proofread, it will be taken into account at the next export to TYPO3.
The export is done every two hours.

If the process takes too long, please write an email to localization@typo3.org

..  _crowdin-crowdin-translation-to-be-translated:

How can I be sure what way a word, term or string is to be translated?
----------------------------------------------------------------------

There are several ways to get help: In the left panel you can either search
the translation memory (TM) or the term base. You can also drop a comment to
start a discussion or ask for advice.

..  _crowdin-crowdin-translation-meet:

Where do I meet all the other translators?
------------------------------------------

There is a good chance to find help and endorsement in the TYPO3 Slack
workspace. Try the `Translation Slack channel #typo3-translations`_.


..  _Translation Slack channel #typo3-translations: https://typo3.slack.com/app_redirect?channel=C032FRT0W
