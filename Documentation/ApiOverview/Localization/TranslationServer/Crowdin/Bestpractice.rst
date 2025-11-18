..  include:: /Includes.rst.txt
..  index:: Crowdin; Best Practice
..  _crowdin-bestpractice


================================
Crowdin Best Practice
================================

..  contents::
    :local:
    :depth: 2
:

Crowdin offers a wealth of settings and views, which make the work of translating a
process where the meaning of the individual words and phrases really comes into focus.
It is a tool that not only helps you get a handle on the translations, but also to
ensure that everything makes sense in the chosen language. One of the biggest
advantages of Crowdin is that you can work both quickly and efficiently, while
also giving you the opportunity to go in-depth with the language and nuances that
professional translations require.

With a good basic setup of your Crowdin interface, the work will be less nerve-wracking,
and you will find that you get a lot done. It often pays to invest time in customizing
your personal settings in Crowdin so that you get the most out of the features the
tool offers. For example, you can sort and filter files, choose from different
views, and easily navigate between projects. You can also customize the editor
to suit your work style, and leverage or change hotkeys to optimize workflow.

..  note::
    Crowdin has a very well-developed help and an active development environment,
    where improvements and changes are regularly made that can affect features
    and screenshots. Therefore, we prefer to link to Crowdin's own help pages
    rather than maintain an actual help section for Crowdin in TYPO3's documentation,
    as it ensures that you always have access to the latest and most up-to-date
    information.


..  _crowdin-bestpractice-get-started:

Get started with Crowdin
========================

Below you will find a few tips and recommendations that will hopefully inspire you
to make TYPO3 available to many more users – in their own language. Translating
TYPO3 is not only about making the system usable for more people, but also an
opportunity to strengthen the community and collaboration across countries and
cultures. The more people who contribute, the better the quality of the translations
and the overall experience for all users.

The recommendations are divided into some general sections. First, there are a
few general considerations before you start translating a project. Then follows
concrete recommendations and practical tips for working in Crowdin if you want
to translate. Finally, tips and recommendations are presented for you who need
to validate translated words and strings so that you can ensure a consistent and
high quality.

TYPO3 has already organized projects and files in a way that follows Crowdin's
own recommendations. However, as a translator, there will be settings and working
methods that you can adapt to your own needs. This gives you flexibility and the
opportunity to work in the way that suits you best – whether you prefer to translate
directly in Crowdin, whether you use EXT:Crowdin, or if you want to work offline
and upload the files later.

..  _crowdin-bestpractice-in-short:

Best practice in short:
-----------------------

EXT:Crowdin Overview
~~~~~~~~~~~~~~~~~~~~

- **Purpose**: Integrates Crowdin’s in-context editing into TYPO3 for easy translation of backend XLF files.
- **Benefits**:
    - Streamlined workflow without switching platforms.
    - Provides context for each string by showing where it’s used in TYPO3.
    - Helps track translated vs. missing files.

Crowdin Setup
~~~~~~~~~~~~~

- **Prerequisites**: Must be a translator or proofreader in Crowdin and logged in.
- **Process**:
    - Open project dashboard → select language → choose files to translate.
    - Options: Translate all files or single file.
- Recommended View: “Comfortable” Editor View for better overview and tools.

Editor Features
~~~~~~~~~~~~~~~

- Shows source text, TM suggestions, comments, and string status.
- Includes filtering, search, glossary, and TM access.
- Keyboard shortcuts available for efficiency.

Glossary
~~~~~~~~

- Ensures consistent terminology across projects.
- TYPO3 has a shared glossary (for example TypoScript, TsConfig, Cache).
- Contributors can add or improve terms in Crowdin.

Translation Memory (TM)
~~~~~~~~~~~~~~~~~~~~~~~

- Stores approved translations for reuse.
- Saves time and ensures consistency.
- TYPO3 has a shared TM that grows over time.
- Avoid mixing similar but different phrases to maintain quality.

Collaboration
~~~~~~~~~~~~~

- Use Slack channels:
    - **TYPO3 translations**: Questions and issues.
    - **TYPO3 localization team**: Process and coordination.
- Share experiences and tips for better results.

The daily work
~~~~~~~~~~~~~~

- Skip difficult strings and return later.
- Do **not** translate placeholders in curly brackets (e.g., {@viewPortLabel}).
- Don’t rely solely on Crowdin’s percentage counters—quality matters more than quantity.
- Review translations for consistency and natural language.

Final Tips
~~~~~~~~~~

- Use shortcuts for speed.
- Perform an extra review for spelling, clarity, and user-friendliness.
- Engage with the community to improve overall translation quality.

..  _crowdin-bestpractice-initial:

Initial considerations
----------------------

Before you start translating a project, there are some initial considerations that
may be good to consider. For example, start with a project that has a smaller
number of words and strings. This makes the work more manageable and increases
the joy of finishing a project, so you avoid getting completely worn out. It's
important to choose a project that motivates you so that you stay engaged.

A good idea is to start by translating a single file in a project. The different
files are often used in different parts of an extension, and it is easier to
understand the context if you work with individual files. This will help you
understand how the text is used and ensure that the translation is appropriate
for the situation.

Choose a project that you think is already used in your language area, or a project
that you are going to work on and want to give your customers/users access to in
their own language. Alternatively, you can choose one of the projects that in
TYPO3's Extension Repository have the most likes and are thus also the most popular.
Popular projects typically have a lot of users, so your contribution will have a
big impact.

If you want to get started with the TYPO3 CMS project, there are typically many
words (>60.000 and counting) and strings that need to be translated. Here, it is
especially important to have a good plan from the start: A good start is the
Glossary with all the terms. Continue with files in the main branch – then you
know that you will hit the most users. We still hold previous (E)LTS versions
in but unless you have massive energy, leave these files.

And follow the recommendations above, work in a structured way through files and
projects. It can be an advantage to set intermediate goals along the way, so that
you stay motivated even if the project is big.

To wrap it up:

*   Start with a small project with a few words and strings to make the work manageable.
*   Choose a project that motivates you to keep your spirits up.
*   Feel free to translate one file at a time to get a better understanding of the context.
*   Choose projects that are already in use in your language area or that you will be working on yourself.
*   Consider tackling popular projects – your contribution will have a greater impact.
*   If you are translating TYPO3 CMS, start with the Glossary if it's not already translated, and continue in the main branch to reach the most users.
*   Work in a structured way and preferably set sub-goals to maintain motivation in larger projects.

..  _crowdin-bestpractice-use-ext-crowdin:


Use EXT:Crowdin
---------------

There is an extension that you can use with great advantage for translations of
both frontend and backend. EXT:Crowdin integrates the in-context editing of Crowdin
into TYPO3, making it quick and easy to add translations of XLF files used in the
backend. With this extension, you can get a more streamlined workflow, where you
don't have to switch between multiple programs or platforms. This allows you to
work more efficiently and easily keep track of which files have been translated
and which ones are missing. And most important: the extension gives you context
to the string, you currently translate, because you can see right away where
it is used in TYPO3.

You find the Extension here: `Extension Crowdin | TER`_

.. _Extension Crowdin | TER: https://extensions.typo3.org/extension/crowdin

..  _crowdin-bestpractice-setup-translating:

Crowdin setup when translating
------------------------------

The prerequisite for getting started is that you are either a translator or proofreader
in Crowdin, and that you are logged in with your user profile. When you open Crowdin
and choose to start translating a project, the project's Dashboard opens, and you
get a list of all the languages that are available for translation in the project.
Select your language and the files that can be translated will appear. Here you
have the option to start translating all files (Translate All) or start with a
single file (the three dots ···), as described in the introductory considerations above.

Now you're up and running! We recommend that you stay with the default Editor
View "Comfortable". Here you have an overview of several parts of your work at the same time. You can
see the source text, suggestions from Translation Memory, comments from other
translators, and the status of each string. Editor View also offers a range of
features that make it easier to work with larger projects, such as filtering strings
by status, search function, and accessing glossary and TM directly from the editor.

For a detailed presentation of the translation view, see Crowdin Docs. Here you
will also find guides to the different editor options and tips on how to get the
most out of the tool.

You find the Crowdin Docs here: `Crowdin Docs`_

.. _Crowdin Docs: https://support.crowdin.com/

..  _crowdin-bestpractice-glossary:

Working with Glossary
---------------------

A Glossary is used to establish a terminology and frequently used terms within a
project. In TYPO3 we have a common Glossary – The TYPO3 CMS Great Glossary. Here
we have selected several terms that are often used in TYPO3 and that must be
written consistently in all projects. It can be terms like 'TypoScript,' 'TsConfig,'
'Cache,' and so on. A well-maintained glossary helps to ensure that terminology is
consistent across translations, making it easier for both new and experienced users
to navigate the system.

Working with Glossary is work-in-progress, and you are welcome to maintain it in
your preferred language. If you come across new terms or see opportunities to
improve definitions, you can contribute directly in Crowdin. This strengthens
collaboration and makes it easier for future translators to deliver high quality.

You can read more about creating and using Glossary on Crowdin Docs: `Glossary | Crowdin Docs`_

.. _Glossary | Crowdin Docs: https://support.crowdin.com/glossary/

.. _crowdin-bestpractice-tm:

Translation Memory (TM)
-----------------------

Translation Memory(TM) is a central part of a translation tool like Crowdin. TM
consists of a database that constantly stores words and phrases as you go and
offers previous translations as you work. This saves time and ensures a consistent
translation style, especially on large projects where many strings recur across files.

In TYPO3 we have a common TM – The TYPO3 CMS Great TM. Here, a large library is
slowly and patiently built up, which helps in the daily work. TM will constantly
suggest strings from TM that match either 100% or close by. In this way, you can
quickly move on in the work and avoid doing duplicate work. Consider using existing
translated strings instead of adding new ones, as this ensures consistency across
the project.

Only translated texts and words that have been approved by a proofreader are stored
in TM. It means a lot for the quality of TM that we do not mix up too many 'almost
identical' words and sentences in the same TM. A good TM makes it easier to achieve
consistency in translations, and you don't have to reinvent the wheel repeatedly.

Read more about Translation Memory on Crowdin Docs: `Translation Memory | Crowdin Docs`_

.. _Translation Memory | Crowdin Docs: https://support.crowdin.com/translation-memory/

..  _crowdin-bestpractice-shortcuts:

Shortcuts and efficiency
------------------------

In Editor View, you can access a wide range of shortcuts via the keyboard. You
can view the list by clicking on the small keyboard icon in the top right corner.
Shortcuts can save you a lot of clicks and make it easier to navigate, especially
when you're working on large projects. Check out the list of shortcuts and try it
out – you'll quickly discover which ones best suit your working style.

.. _crowdin-bestpractice-communication:

Communication and collaboration
-------------------------------

Write, comment and suggest! In TYPO3, we primarily have two channels in Slack:
TYPO3 translations for questions and problems about working with translations,
and TYPO3 localization team for driving the process around Crowdin, TYPO3 and
localization. It is important to use these channels actively, as collaboration
and knowledge sharing often lead to better and more accurate translations. You
can ask questions, share experiences, and help others if you encounter challenges.

Go to TYPO3 Slack:

*   Sign Up for a `TYPO3 Slack Account`_
*   Channel questions and problems working with translations: `typo3-translations | Slack`_
*   Channel for the localization team: `typo3-localization-team | Slack`_

.. _TYPO3 Slack Account: https://docs.typo3.org/m/typo3/guide-step-by-step/main/en-us/10GettingStarted/05MeetTheCommunity/SignUpForATypo3SlackAccount.html
.. _typo3-translations | Slack: https://typo3.slack.com/archives/C032FRT0W
.. _typo3-localization-team | Slack: https://typo3.slack.com/archives/CR75200FL

..  _crowdin-bestpractice-stuck:

If you get stuck
----------------

Sometimes a text can be difficult to translate. Consider leaving it for later.
Once you've worked through the rest of the translation, you'll often get a better
picture of the overall text, and it'll be easier to come back and translate the
remaining sentences and words. If in doubt, you can also ask in the Slack channels
or seek advice from more experienced translators.

..  _crowdin-bestpractice-stick-lyrics:

Stick to the lyrics
-------------------

Do not translate texts within curly brackets (for example, {@viewPortLabel}). These
are placeholders that are filled in by TYPO3 when the text is displayed. Translating
them can lead to system errors or features not working as expected. It is therefore
important to keep an eye on these and leave them unchanged.

..  _crowdin-bestpractice-100-percent:

Don't trust 100% on 100%
------------------------

Crowdin shows one percent for each language, but it's a bit misleading. Old versions
do not have to be completely translated, so a language can easily be finished, even if
the counter may only say 50%. And even if it says "100% finished", it doesn't mean
that everything just plays – it's always a good idea to just read through the text
and check if it sounds proper and natural in your language. Quality is not
only a question of quantity, but also of whether the text is understandable and accurate.

Inside each version folder there is also a counter, but it only tells you how many
words are missing in that version. This can mean that 50% is either half of 1,000
words or half of 5,000 words – so it is not to be counted on. If we correct just
one word in a sentence, Crowdin counts the entire sentence as changed. Luckily,
it shows the translation from the old version, so you can copy and correct just
that one word – it's fast and saves time.

.. _crowdin-bestpractice-proofreader:

Proofreaders 101
================

Going through many, many translated strings can be a tedious task, but still important for the
overall result. Here are some tips for you that focus on the quality and speed in a balanced
matter.

Use the "QA Checks" feature to solve issues found by Crowdin. Crowdin does a good handfull of
checks for different issues and highlights them as things thats not necessary a problem, but
should be checked. UA Checks is highligted on the project Dashboard. A common issue is, what
Crowdin consider as spell errors. By going through the spellchecks, you can ignore words and
Crowdin should remember and ignore them in the future.

Read more about QA: `QA Check | Crowdin Docs`_

.. _QA Check | Crowdin Docs: https://support.crowdin.com/project-settings/qa-checks/

Use the batch approval view in the Editor view, to get many translations done in a few steps. By changing the
view from "Comfortable" to "Side-by-side", you get a full view of the translated strings and words.
You can select more/all strings and approve all selected strings in one click.

Reviewing translation is explained here: `Side-by-side | Crowdin Docs`_

.. _Side-by-side | Crowdin Docs: https://support.crowdin.com/online-editor/#proofreading

Finally, if you do both translation and approval in Crowdin (some of us do..), there is a neat
little feature we will share with you: The fabulous "Auto-approve" feature! As a proofreader or
higher, translations added by you will be automatically approved, when you save. You find the
feature under the "Editor Settings" just beside your logo in the top right corner.

Aoto-approval is explained here: `Editor Settings | Crowdin Docs`_

.. _Editor Settings | Crowdin Docs: https://support.crowdin.com/online-editor/#editor-settings

.. _crowdin-bestpractice-final:

Final thoughts
==============

To ensure the quality of the translations, it may be a good idea to do an extra
review where you check for consistency, spelling mistakes and whether the texts
sound natural in in your language. Put yourself in the position of an unexperienced
user of TYPO3. Would you understand the translation?

Feel free to share your experiences and best tips with the community – it empowers
everyone, and together we can make TYPO3 even better and more accessible to users
all over the world.

.. _crowdin-bestpractice-further-readings:

Further readings
----------------

Get inspired by Martin Pribyl's article about how he did a full translation and
proofreading of TYPO3 CMS into Czech language: `Bringing Czech to TYPO3 - My Translation Journey`_

.. _Bringing Czech to TYPO3 - My translation Journey: https://typo3.org/article/bringing-czech-to-typo3-my-translation-journey

