.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _example-configuration:

============================================
Example configuration of backend user groups
============================================

How backend user groups can be :ref:`categorized <_available-acl-options>`,
and organized using :ref:`naming conventions <_naming-convention>`
to distinguish their purpose or context as well as following best practice
and more advanced examples of group structures for projects with a single or multisite setup
are discussed.

.. _single-site-structure:

Backend groups’ structure for a small project
==============================================

When setting up backend groups and permissions for small, single-site projects
future complexity should be considered. Organizing groups by best practice from the start
makes future extension and maintenance easier.

Consider a scenario where two role groups are required: one for general content management,
named :samp:`Content Editor`, and one for survey management, named :samp:`Survey Manager`.

The following conditions should be met:

* Both roles should manage content in all languages
* Both roles should perform any file operations
* The Content Editor role has a dedicated file mount for organizing files
* The Survey Manager role should have access to a dedicated file mount within the same file storage
* The Content Editor role should be able to view files uploaded by users with the Survey Manager role, as they might need them for blog posts mentioning the surveys
* The Content Editor role should manage all types of content, except for surveys
* The Content Editor should have access to a dedicated branch in system categories
* The Survey Manager role should only see the storage folder and the part of the pages tree where the surveys are listed and rendered
* The Survey Manager role does not need access to any system categories

With these requirements in mind, the backend groups structure can be planned.
Following best practice of having :ref:`System Groups <_system-groups>`
and :ref:`Access Control List Groups <_acl-groups>`, it could look like this:

..  uml:: _backend-groups-simple-project.plantuml
    :align: center
    :width: 700

Having defined all the required :samp:`System` and :samp:`Access Control List` groups,
they can be combined to fulfill the :samp:`Content Editor` and :samp:`Survey Manager`
role requirements.

..  uml:: _backend-groups-simple-project-organized.plantuml
    :align: center
    :width: 700

The :samp:`System` and :samp:`Access Control List (ACL)` groups serve as components
that can be integrated into a larger entity, in this case, the role group.
These role groups can then be assigned to users. As previously mentioned,
permissions should only be assigned to users via role groups.

.. _multisite-structure:

Backend group structure for a multi-site project
==================================================

When creating backend user groups for a multi-site project, the approach is
the same as that of smaller, :ref:`single-site projects <_single-site-structure>`.
Adhering to recommended best practice from the start simplifies building the website
and prepares for a more advanced setup.

This scenario describes a project with three separate sites (a multi-site setup).
There will be three distinct :samp:`Content Editors` roles, one for each site,
along with other roles that will have cross-site access and permissions
to manage content.

The following conditions should be met:

* Project has 3 separate sites: Website A, Website B, Website C
* Project has one default language and one translation to English language
* For each site there are separate Content Editor roles as they will have different permissions
* Content Editor roles on Website A and Website C will have access to all languages, while the Content Editor role for Website B will have access only to the English language
* Each Content Editor role  should have access to dedicated system categories branch
* Each Content Editor role can manage general content elements
* Content Editor role on Website A and C can manage news
* Content Editor role on Website A and C can manage galleries
* Content Editor role on Website A can manage use custom page types
* Content Editor role on Website A can manage contact forms (send responses etc.)
* Content Editor role on Website B can manage surveys

Start by creating the necessary groups to form role groups. This includes system groups
for each site and shared groups across different roles and sites. Next, define the
ACL groups, which will be universally reusable for all role groups on any site.

..  uml:: _backend-groups-multisite-project-1.plantuml
    :align: center
    :width: 700

..  uml:: _backend-groups-multisite-project-2.plantuml
    :align: center
    :width: 700

Groups specific to particular sites (e.g., page groups, database mounts) have
been identified as well as the :samp:`shared groups`, which are universal,
and reused across role groups. Use shared groups for
for roles for single sites as well as for cross-site groups.

The ACL groups could be further granulated, by separating out permissions
for different content elements and dividing records’ related groups into multiple
ones — for editing records, managing lists and details through plugins, etc.
It is not done here to avoid overly complicating the diagram, which is already
quite comprehensive. However, in your setup, it might be necessary to create
more ACL groups, each responsible for a smaller set of permissions than those shown here.

The desired backend groups structure and aggregation could look like this:

..  uml:: _backend-groups-multisite-project-organized.plantuml
    :align: center
    :width: 700

The key concept that you should grasp here is that small backend groups
are combined to form a Role group. Role groups are the 'top' tier and only they
can be assigned to users later on.
