:navigation-title: General Recommendations
..  include:: /Includes.rst.txt

..  _seo-recommendations:

==============================================
General SEO Recommendations for TYPO3 projects
==============================================

..  _seo-recommendations-extensions:

Recommendations for additional SEO extensions
=============================================

The TYPO3 Core ships the whole API and the needed fields to fulfill all necessary technical
requirements of implementing SEO.

Besides that, there are lots of tools you can use to optimize your rankings.

If you install additional SEO extensions in TYPO3, make sure you check the following recommendations:

*   The extension **should** stick to the Core fields where possible
*   The extension **should** stick to the Core behaviour where possible
*   The extension **could** extend TCA with additional helpers for your editors, like:

    *   Readability checks
    *   Keyword and content checks
    *   Previews
    *   Page speed insights
    *   Large-Language-Model (LLM)-enabled text creation

Some of these tools might need external services, others can work completely on-premise.

..  _seo-recommendations-field-description:

Recommendations for the `description` field
===========================================

..  danger::

    Current state of SEO research states that the description in the meta-tags
    should be either lovely crafted by hand, or left out completely. (end of 2019)

    If you are unsure contact an expert.

*   Duplicate meta descriptions should only be used under specific circumstances
*   Duplicate meta descriptions should only be used on a few pages
*   Leave the description empty if you do not can provide one
*   Provide an engaging explanation of your page, to ensure people will be motivated to visit your site
*   If SEO is not your thing, professional services are available to support you
