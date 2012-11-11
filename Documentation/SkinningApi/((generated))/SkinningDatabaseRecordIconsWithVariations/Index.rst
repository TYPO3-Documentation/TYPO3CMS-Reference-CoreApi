.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Skinning database record icons with variations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Introduction
""""""""""""

Database records in TYPO3 has and icon associated which can be shown
in the interface. But the icon might change according to internal
settings in the record; other icons might be used as alternatives to
the default and for each possible icon certain "states" might reflect
on how the icon look. For instance, if a record has the "hidden" flag
set, the icon should be gray with a red cross over in order to reflect
this state visually.

Until version 3.6.0 TYPO3 has automatically calculated new versions of
database icons when needed by the system. Thus you needed to supply
only one icon - all variations would be automatically generated and
stored in typo3temp/. However this auto generation depended on GDlib
with gif-support and that has been a well known problem for many years
since not everyone has access to these features.

In TYPO3 3.6.0 the automatic generation is disabled (can be enabled by
setting $TYPO3\_CONF\_VARS['GFX']['noIconProc']=0) and instead most
icons have their most used states shipped along pre-rendered instead.

This solution not only solves the last mandatory dependency on GDlib
for TYPO3 but also provides a way for skinning of various icon states
- since skinned icons would be too hard to do processing for!


Pre-rendered icon states
""""""""""""""""""""""""

The number of variations for an icon of a database record depends on
configuration in $TCA. The most easy way to get an overview of the
icons you would need to produce as variations is to use the tool
"Table Icon Listing" in the "extdeveval" extension.

This is an example of how that tool shows the icons for "Backend
Users" and their variations:

|img-46|

Notice, the default icon is "gfx/i/be\_users.gif"

- If the hidden flag is set, the icon name is "be\_users\_\_h.gif"

- If the starttime is set, the icon name is "be\_users\_\_t.gif"

- If both starttime and hidden flag is set, the icon name is
  "be\_users\_\_ht.gif"

- If an icon carries a state that is not found, then show
  "be\_users\_\_x.gif" (default icon for a state that does not have an
  icon. If this icon is not set a generalized default icon is shown;
  thus a record with a special state will never be shown just plain!)

For an extension like "mininews" we can perform the same analysis:

|img-47|

Again, notice how the variations over "icon\_tx\_mininews\_news.gif"
is prefixed with "flags" like "\_\_h" and "\_\_x"

If we enable more of the render options we might eventually hit a
combination of options which is  *not* found pre-rendered though:

|img-48|

As you can see the "endtime" flag has no icon associated with it.


Automatic creation of pre-made variations
"""""""""""""""""""""""""""""""""""""""""

In order to create variations for inclusion in your extensions (for
the default icon) you can enable the rendering of icons if you like
(in localconf.php)::

   $TYPO3_CONF_VARS['GFX']['noIconProc']=0;

Then you reload the "Table Icon Listing" and the icons are generated
in typo3temp/:

|img-49| If you want the new icons to be included in the extension you
simply

- Move them from typo3temp/ into the extension folder (here
  "typo3conf/ext/mininews/")

- Rename them to the expected names, e.g.
  "icon\_fb7ee72ecd\_icon\_tx\_mininews\_news\_\_f.gif.gif" to
  "icon\_tx\_mininews\_news\_\_f.gif" (remember to also remove the
  "double-gif" in the extension!)

And after another reload you will be assured that the icon is found
correctly:

|img-50|

( **Tip for code hackers:** Inside
"ext/extdeveval/mod1/class.tx\_extdeveval\_iconlister.php there is a
line with a function call, "$this->renameIconsInTypo3Temp();" which is
commented out - if you uncomment this function call it will rename
icons made in typo3temp/ to filenames that can be copied directly into
the extension you are making. Basically this removes "icon\_fb7ee...."
from the temporary file!)


Limits to number of pre-made icons
""""""""""""""""""""""""""""""""""

Since the number of combinations can be staggering you might often
have to settle for a compromise where you define which states are the
most likely to occur and then give those priority when you create
variations - otherwise you might have to make hundreds of icons!

Thus you can find that the pages table does not have pre-made icons
for all "Module" icons. Only the "hidden" state has been considered
general enough to allow for a pre-made icon - enabling starttime
results in a "no\_icon\_found.gif" version as you can see below:

|img-51|


