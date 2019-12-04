.. include:: ../../../../Includes.txt


.. _ModifyLanguagePackRemoteBaseUrlEvent:


====================================
ModifyLanguagePackRemoteBaseUrlEvent
====================================

Event to modify the main URL of a language.

API
---


 - :Method:
         getBaseUrl()
   :Description:
         Returns the base URL for fetching language packs.
   :ReturnType:
         \Psr\Http\Message\UriInterface


 - :Method:
         setBaseUrl(UriInterface $baseUrl)
   :Description:
         Set / overwrite base URL for fetching language packs.
   :ReturnType:
         void


 - :Method:
         getPackageKey()
   :Description:
         Get the current package key.
   :ReturnType:
         string

